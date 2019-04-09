<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 18/12/2018
 * Time: 16:35
 */
namespace App\Manager;

use App\Entity\SchoolYear;
use App\Entity\User;
use App\Provider\SettingProvider;
use App\Util\SchoolYearHelper;
use App\Util\UserHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DashboardManager
 * @package App\Manager
 */
abstract class DashboardManager implements DashboardInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var MessageManager
     */
    private $messageManager;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $timezone;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var Request
     */
    private $stack;

    /**
     * @var SettingProvider
     */
    private $settingManager;

    /**
     * DashboardManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param MessageManager $messageManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param RouterInterface $router
     * @param ContainerInterface $container
     * @param TranslatorInterface $translator
     * @param RequestStack $stack
     * @param SettingProvider $settingManager
     */
    public function __construct(EntityManagerInterface $entityManager, MessageManager $messageManager,
                                AuthorizationCheckerInterface $authorizationChecker,
                                RouterInterface $router, ContainerInterface $container, TranslatorInterface $translator,
                                RequestStack $stack, SettingProvider $settingManager)
    {
        $this->entityManager = $entityManager;
        $this->messageManager = $messageManager;
        $this->authorizationChecker = $authorizationChecker;
        $this->router = $router;
        $this->timezone = $container->getParameter('timezone');
        $this->translator = $translator;
        $this->stack = $stack;
        $this->settingManager = $settingManager;
    }

    /**
     * @var ArrayCollection
     */
    private $providers;

    /**
     * getProvider
     * @param string $providerName
     * @return EntityProviderInterface
     */
    public function getProvider(string $providerName): EntityProviderInterface
    {
        if (! $this->getProviders()->containsKey($providerName))
            $this->addProvider($providerName);

        return $this->getProviders()->get($providerName);
    }

    /**
     * getProviders
     * @return ArrayCollection
     */
    public function getProviders(): ArrayCollection
    {
        if(empty($this->providers))
            $this->providers = new ArrayCollection();
        return $this->providers;
    }

    /**
     * addProvider
     * @param string $providerName
     * @return DashboardInterface
     */
    private function addProvider(string $providerName): DashboardInterface
    {
        if (class_exists($providerName))
            $this->getProviders()->set($providerName, new $providerName($this->getEntityManager(), $this->getMessageManager(), $this->getAuthorizationChecker(), $this->getRouter()));

        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @return MessageManager
     */
    public function getMessageManager(): MessageManager
    {
        return $this->messageManager;
    }

    /**
     * @return AuthorizationCheckerInterface
     */
    public function getAuthorizationChecker(): AuthorizationCheckerInterface
    {
        return $this->authorizationChecker;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * getTimetableProps
     * @return array
     */
    public function getTimetableProps(): array
    {
        $translations['My Dashboard'] = $this->getTranslator()->trans('My Dashboard');
        $translations['Loading'] = $this->getTranslator()->trans('Loading');
        $translations['School Closed'] = $this->getTranslator()->trans('School Closed');
        $translations['Next Day'] = $this->getTranslator()->trans('Next Day');
        $translations['Previous Day'] = $this->getTranslator()->trans('Previous Day');
        $translations['Today'] = $this->getTranslator()->trans('Today');
        $translations['Phone'] = $this->getTranslator()->trans('Phone');
        $translations['Personal Calendar'] = $this->getTranslator()->trans('Personal Calendar');
        $translations['School Calendar'] = $this->getTranslator()->trans('School Calendar');
        $translations['All Day Event'] = $this->getTranslator()->trans('All Day Event', [], 'mobile');
        $translations['Bookings'] = $this->getTranslator()->trans('Bookings');
        $translations['View Details'] = $this->getTranslator()->trans('View Details');
        $translations['Take Attendance by Class'] = $this->getTranslator()->trans('Take Attendance by Class');
        $translations['Close without saving data.'] = $this->getTranslator()->trans('Close without saving data.', [], 'mobile');
        $translations['on'] = $this->getTranslator()->trans('on');
        $translations['Take Attendance by Roll Group'] = $this->getTranslator()->trans('Take Attendance by Roll Group');
        $translations['There are no records to display.'] = $this->getTranslator()->trans('There are no records to display.');
        $translations['An error occurred collecting the timetable information. You may not have access to this timetable.'] = $this->getTranslator()->trans('An error occurred collecting the timetable information. You may not have access to this timetable.', [], 'mobile');

        $properties['translations'] = $translations;
        $properties['locale'] = $this->getRequest()->get('_locale');
        $properties['person'] = UserHelper::getCurrentUser()->getId();

        $googleAvailable = $this->getSettingManager()->getSettingByScopeAsBoolean('System', 'googleOAuth') && $this->getSession()->get('googleAPIAccessToken', false) !== false;
        $schoolAvailable = empty($this->getSettingManager()->getSettingByScopeAsString('System', 'calendarFeed')) ? false : true ;
        $properties['allowSchoolCalendar'] = $this->getPerson()->getViewCalendarSchool() === 'Y' ? (true && $googleAvailable && ! empty($schoolAvailable)) : false ;
        $properties['allowPersonalCalendar'] = $this->getPerson()->getViewCalendarPersonal() === 'Y' ? (true && $googleAvailable && ! empty($this->getPerson()->getCalendarFeedPersonal())) : false ;
        $properties['allowSpaceBookingCalendar'] = $this->getPerson()->getViewCalendarSpaceBooking() === 'Y' ? true : false ;
        $properties['schoolYear'] = SchoolYearHelper::getSchoolYearAsArray();
        $properties['daysOfWeek'] = SchoolYearHelper::getDaysOfWeek();
        $properties['gibbonHost'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'absoluteURL');
        $properties['dashboardName'] = $this->getDashboardName();

        return $properties;
    }

    /**
     * getTranslator
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * getRequest
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->stack->getCurrentRequest();
    }

    /**
     * @return SettingProvider
     */
    public function getSettingManager(): SettingProvider
    {
        return $this->settingManager;
    }

    /**
     * getSession
     * @return SessionInterface|null
     */
    public function getSession(): ?SessionInterface
    {
        if ($this->getRequest()->hasSession())
            return $this->getRequest()->getSession();
        return null;
    }

    /**
     * isDisplayLessons
     * @return bool
     */
    public function isDisplayLessons(): bool
    {
        if (property_exists($this, 'displayLessons'))
            return $this->displayLessons ? true : false;
        return true;
    }
}