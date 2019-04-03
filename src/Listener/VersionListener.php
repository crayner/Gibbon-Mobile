<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 2/03/2019
 * Time: 10:38
 */
namespace App\Listener;

use App\Manager\FlashBagManager;
use App\Provider\SettingProvider;
use App\Manager\VersionManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class VersionListener
 * @package App\Listener
 */
class VersionListener implements EventSubscriberInterface
{
    /**
     * @var SettingProvider
     */
    private $manager;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var FlashBagManager
     */
    private $flashBagManager;

    /**
     * VersionListener constructor.
     */
    public function __construct(SettingProvider $manager, RouterInterface $router, FlashBagManager $flashBagManager)
    {
        $this->manager = $manager;
        $this->router = $router;
        $this->flashBagManager = $flashBagManager;
    }

    /**
     * getSubscribedEvents
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $listeners = [
            KernelEvents::REQUEST => 'checkVersion',
        ];

        return $listeners;
    }

    /**
     * checkVersion
     * @param GetResponseEvent $event
     */
    public function checkVersion(GetResponseEvent $event): void
    {
        $route = $event->getRequest()->get('_route');

        if (strpos($route, '_') === 0)
            return ;
        if (strpos($route, 'api_') === 0)
            return ;

        $manager = new VersionManager();
        $manager->setSettingManager($this->getSettingManager());
        if (! $manager->checkVersion())
        {
            $response = new RedirectResponse($this->getRouter()->generate('_version_warning'));
            $this->getFlashBagManager()->addMessages($this->getSettingManager()->getMessageManager());
            $event->setResponse($response);
        }
    }

    /**
     * @return SettingProvider
     */
    public function getSettingManager(): SettingProvider
    {
        return $this->manager;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    /**
     * @return FlashBagManager
     */
    public function getFlashBagManager(): FlashBagManager
    {
        return $this->flashBagManager;
    }
}