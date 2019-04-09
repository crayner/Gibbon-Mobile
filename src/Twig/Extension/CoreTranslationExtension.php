<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Twig\Extension;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class CoreTranslationExtension
 * @package App\Twig\Extension
 */
class CoreTranslationExtension extends AbstractExtension
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @return string
     */
    public function getName()
    {
        return 'core_translation_extension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('coreTranslations', [$this, 'getCoreTranslations']),
            new TwigFunction('method_exists', [$this, 'method_exists']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('transPlural', [$this->translator, 'transPlural']),
        ];
    }

    /**
     * CoreTranslationExtension constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * getCoreTranslations
     * @return array
     */
    public function getCoreTranslations(): array
    {
        $translations = [];
        $translations['Your session is about to expire: you will be logged out shortly.'] = $this->translator->trans('Your session is about to expire: you will be logged out shortly.');
        $translations['Logout'] = $this->translator->trans('Logout');
        $translations['Home'] = $this->translator->trans('Home');
        $translations['Menu'] = $this->translator->trans('Menu', [], 'mobile');
        $translations['Stay Connected'] = $this->translator->trans('Stay Connected', [], 'mobile');
        return $translations;
    }

    /**
     * method_exists
     * @param $object
     * @param $method
     * @return bool
     */
    public function method_exists($object, $method)
    {
        return method_exists($object, $method);
    }
}