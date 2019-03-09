<?php
namespace App\Manager;

use App\Entity\StringReplacement;
use App\Provider\SettingProvider;
use App\Provider\StringReplacementProvider;
use App\Repository\StringReplacementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Intl\Exception\InvalidArgumentException;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Translation\TranslatorInterface as LegacyTranslatorInterface; // Some Symfony Code in 4.2 still requires this interface

class TranslationManager implements TranslatorInterface, TranslatorBagInterface, LocaleAwareInterface, LegacyTranslatorInterface
{
     public static $languages = [
        'nl_NL' => 'Dutch - Nederland',
        'en'    => 'English - United Kingdom',
        'en_GB' => 'English - United Kingdom',
        'en_US' => 'English - United States',
        'es_ES' => 'Español',
        'fr_FR' => 'Français - France',
        'it_IT' => 'Italiano - Italia',
        'pt_BR' => 'Português - Brasil',
        'ro_RO' => 'Română',
        'sq_AL' => 'Shqip - Shqipëri',
        'vi_VN' => 'Tiếng Việt - Việt Nam',
        'ar_SA' => 'العربية - المملكة العربية السعودية',
        'th_TH' => 'ภาษาไทย - ราชอาณาจักรไทย',
        'zh_HK' => '體字 - 香港'
    ];

    /**
     * @var null|string
     */
    private $domain;

    /**
     * Translates the given message.
     *
     * @param string      $id         The message id (may also be an object that can be cast to string)
     * @param array       $parameters An array of parameters for the message
     * @param string|null $domain     The domain for the message or null to use the default
     * @param string|null $locale     The locale or null to use the default
     *
     * @return string The translated string
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        if (empty($id) || $domain === false)
            return $id;

        $domain = $domain ?: $this->getDomain();

        $options = $parameters;
        $parameters = [];
        foreach($options as $name=>$value)
        {
            if (mb_substr($name, 0, 1) === '{' || mb_substr($name, -1) === '}') {
                $parameters[$name] = $value;
            } else {
                $parameters['{'.$name.'}'] = $value;
                if (strval(intval($name)) !== strval($name))
                    $parameters[$name] = $value;
            }
        }

        $trans = $this->translator->trans($id, $parameters, $domain, $locale) ?: $id;

        $trans = strtr($trans, $parameters);

        if (mb_strpos($trans, '|') !== false)
        {
            if ($trans === '|')
                $trans = strtr($id, $parameters);
            else {
                $trans = explode('|', $trans);
                if (count($trans) === 2)
                    $trans = $trans[1];
                else
                    throw new \Symfony\Component\Translation\Exception\InvalidArgumentException(sprintf('The translations matrix for "%s" does not know how to manage multiple translations from a PO file. [ %s ]'. $id, implode('|',$trans)));
            }
        }

        return $this->getInstituteTranslation($trans, $locale);
    }

    /**
     * transPlural
     * Required due to old Gibbon Translation use of getText PO File Structure.
     * @param $single
     * @param $plural
     * @param int $count
     * @param array $arguments
     * @param null $domain
     * @param null $locale
     * @return string
     */
    public function transPlural($single, $plural, int $count = 1, array $arguments = [], $domain = null, $locale = null)
    {
        if (intval($count) < 2)
            return $this->trans($single, $arguments, $domain, $locale);
        return $this->trans($plural, $arguments, $domain, $locale);
    }

    /**
     * Translates the given choice message by choosing a translation according to a number.
     *
     * @param string      $id         The message id (may also be an object that can be cast to string)
     * @param int         $number     The number to use to find the indice of the message
     * @param array       $parameters An array of parameters for the message
     * @param string|null $domain     The domain for the message or null to use the default
     * @param string|null $locale     The locale or null to use the default
     *
     * @return string The translated string
     *
     * @deprecated use ->trans with option '%count%' => $count
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
    {
        if (empty($id) || $domain === false)
            return $id;
        if (is_array($number))
            $trans = $this->multipleTransChoice($id, $number, $parameters, $domain, $locale) ?: $id;
        else
            $trans = $this->translator->transChoice($id, $number, $parameters, $domain, $locale) ?: $id;

        return $this->getInstituteTranslation($trans, $locale);
    }

    /**
     * Returns the current locale.
     *
     * @return string The locale
     */
    public function getLocale()
    {
        return $this->translator->getLocale();
    }

    /**
     * Sets the current locale.
     *
     * @param string $locale The locale
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public function setLocale($locale)
    {
        return $this->translator->setLocale($locale);
    }

    /**
     * Gets the catalogue by locale.
     *
     * @param string|null $locale The locale or null to use the default
     *
     * @return MessageCatalogueInterface
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public function getCatalogue($locale = null)
    {
        return $this->translator->getCatalogue($locale);
    }

    /**
     * @param $trans
     * @return string
     */
    private function getInstituteTranslation($trans, $locale): string
    {
        if (empty($trans) || empty($this->settingManager->getParameter('db_name')))
            return $trans;

        $strings = $this->getStrings();
        if ((! empty($strings) || $strings->count() > 0) && $strings instanceof ArrayCollection) {
            foreach ($strings->toArray() AS $replacement) {
                if ($replacement->getReplaceMode()==="Partial") { //Partial match
                    if ($replacement->isCaseSensitive()==="Y") {
                        if (strpos($trans, $replacement->getOriginal())!==FALSE) {
                            $trans=str_replace($replacement->getOriginal(), $replacement->getReplacement(), $trans);
                        }
                    }
                    else {
                        if (stripos($trans, $replacement->getOriginal())!==FALSE) {
                            $trans=str_ireplace($replacement->getOriginal(), $replacement->getReplacement(), $trans);
                        }
                    }
                }
                else { //Whole match
                    if ($replacement->isCaseSensitive()==="Y") {
                        if ($replacement->getOriginal()===$trans) {
                            $trans=$replacement->getReplacement();
                        }
                    }
                    else {
                        if (strtolower($replacement->getOriginal())==strtolower($trans)) {
                            $trans=$replacement->getReplacement();
                        }
                    }
                }
            }
        }

        return $trans;
    }

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var StringReplacementRepository
     */
    private $translateRepository;

    /**
     * @var StringReplacementProvider
     */
    private $stringReplacementManager;

    /**
     * @var SettingProvider
     */
    private $settingManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * TranslationManager constructor.
     *
     * @param TranslatorInterface $translator
     * @param StringReplacementProvider $manager
     * @param SettingProvider $settingManager
     * @param LoggerInterface $logger
     * @throws \Exception
     */
    public function __construct(TranslatorInterface $translator, StringReplacementProvider $manager, SettingProvider $settingManager, LoggerInterface $logger)
    {
        $this->settingManager = $settingManager;
        $this->translateRepository = $manager->getRepository();
        $this->logger = $logger;
        $this->stringReplacementManager = $manager;

        $this->translator = $translator;
    }

    /**
     * @var null|Collection
     */
    private $strings;

    /**
     * getStrings
     *
     * @param bool $refresh
     * @return Collection|null
     * @throws \Exception
     */
    public function getStrings($refresh = false): ?Collection
    {
        if (!is_null($this->getSession())) {
            if (empty($this->strings) && !$refresh)
                $this->strings = $this->getSession()->get('stringReplacement', null);
            else
                return $this->strings;
        }

        if ((empty($this->strings) || $refresh) && $this->stringReplacementManager->isValidEntityManager())
            try {
                $this->strings = new ArrayCollection($this->stringReplacementManager->getRepository()->findBy([], ['priority' => 'DESC', 'original' => 'ASC']));
            } catch (TableNotFoundException $e) {
                $this->strings = new ArrayCollection();
            }
        else
            return $this->strings = $this->strings instanceof ArrayCollection ? $this->strings : new ArrayCollection();

        $this->getSession() ? $this->getSession()->set('stringReplacement', $this->strings) : null;

        return $this->strings;
    }

    /**
     * @param Collection|null $strings
     * @return TranslationManager
     */
    public function setStrings(?Collection $strings): TranslationManager
    {
        if (empty($strings))
            $strings = new ArrayCollection();

        $this->strings = $strings;

        return $this;
    }

    /**
     * @param StringReplacement|null $translate
     * @return TranslationManager
     */
    public function addString(?StringReplacement $translate): TranslationManager
    {
        if (empty($translate) || ! $translate instanceof StringReplacement)
            return $this;

        if ($this->getStrings()->contains($translate))
            return $this;

        $this->strings->add($translate);

        return $this;
    }

    /**
     * @param Translate|null $translate
     * @return TranslationManager
     */
    public function removeString(?StringReplacement $translate): TranslationManager
    {
        $this->getStrings()->removeElement($translate);

        return $this;
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        asort($this->source);
        return $this->source;
    }


    /**
     * Translates the given choice message by choosing a translation according to a number.
     *
     * @param string      $id         The message id (may also be an object that can be cast to string)
     * @param int         $number     The number to use to find the indice of the message
     * @param array       $parameters An array of parameters for the message
     * @param string|null $domain     The domain for the message or null to use the default
     * @param string|null $locale     The locale or null to use the default
     *
     * @return string The translated string
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    private function multipleTransChoice($id, $number, array $parameters = [], $domain = null, $locale = null): ?string
    {
        $catalogue = $this->getCatalogue($locale);

        if (! $catalogue->has($id, $domain))
            return $id;

        $message = $catalogue->get($id, $domain);

        $messages = explode("\n", $message);
        $message = reset($messages);

        array_shift($messages);

        $last = end($messages);

        if (empty($last))
            array_pop($messages);

        if (count($messages) !== count($number))
            $this->logger->warning(sprintf('The number of options "%u" in the translation choice does not match the message string count "%u".', count($number), count($messages)), array('numbers' => count($number), 'messages' => $messages, 'id' => $id, 'domain' => $domain, 'locale' => $catalogue->getLocale() ));

        $translations = [];
        foreach($messages as $q=>$item)
            $translations[$id.'.'.$q] = $item;

        $this->getCatalogue($locale)->replace($translations, '_temporary');

        $x = 0;
        $messages = [];
        foreach($translations as $q=>$w) {
            if (empty($number[$x]))
                $number[$x] = 0;
            $parameters['%count%'] = $number[$x];
            $messages['%'.$x.'%'] = $this->transChoice($q, $number[$x++], $parameters, '_temporary', $locale);
        }

        $message = strtr($message, $messages);

        return $message;
    }

    /**
     * @return ?SessionInterface
     */
    public function getSession(): ?SessionInterface
    {
        return $this->settingManager->getSession();
    }

    /**
     * getDomain
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * setDomain
     * @param string|null $domain
     */
    public function setDomain(?string $domain): TranslationManager
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * addResource
     * @param $format
     * @param $resource
     * @param $locale
     * @param null $domain
     */
    public function addResource($format, $resource, $locale, $domain = null): void
    {
        $this->translator->addResource($format, $resource, $locale, $domain);
    }
}