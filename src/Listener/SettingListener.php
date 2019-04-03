<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Listener;

use App\Manager\InstallationManager;
use App\Provider\SettingProvider;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class SettingListener
 * @package App\Listener
 */
class SettingListener implements EventSubscriberInterface
{
    /**
     * @var SettingProvider
     */
    private $manager;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Filesystem 
     */
    private $filesystem;

    /**
     * @var InstallationManager
     */
    private $installationManager;

    /**
     * SettingListener constructor.
     * @param InstallationManager $installationManager
     * @param SettingProvider|null $manager
     */
    public function __construct(InstallationManager $installationManager, ?SettingProvider $manager = null)
    {
        $this->manager = $manager;
        $this->container = $manager->getContainer();
        $this->logger = $this->getContainer()->get('monolog.logger.setting');
        $this->filesystem = new Filesystem();
        $this->setInstallationManager($installationManager);
        $this->getInstallationManager()
            ->setSettingManager($manager)
            ->setLogger($this->logger)
            ->setKernel($this->getContainer()->get('kernel'));
    }

    /**
     * getSubscribedEvents
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $listeners = [
            KernelEvents::TERMINATE => ['onTerminate', -2048],
            KernelEvents::RESPONSE => ['saveSettingCache', 32],
            KernelEvents::REQUEST => ['onRequest', 0],
        ];

        return $listeners;
    }

    /*
     * saveSettingCache
     */
    public function saveSettingCache()
    {
        if ($this->manager instanceof SettingProvider)
            $this->manager->saveSettingCache();
    }

    /**
     * onTerminate
     * @throws \Exception
     */
    public function onTerminate()
    {
        if ($this->getInstallationManager()->getMobileParameter('installation_progress', 'start') !== 'complete')
            return ;
        if (empty($lastTranslationRefresh = $this->getInstallationManager()->getMobileParameter('translation_last_refresh', null)))
            return ;
        if (empty($lastSettingRefresh = $this->getInstallationManager()->getMobileParameter('setting_last_refresh', null)))
            return;

        if ($this->manager instanceof SettingProvider) {
            $this->manager->saveSettingCache();
            $clearCache = false;
            if ($lastTranslationRefresh !== null && $lastTranslationRefresh < strtotime('-'.$this->manager->getParameter('translation_refresh', 90).' Days')) {
                $this->installationManager->translations();
                $this->getLogger()->info(sprintf('%s: The translation files were refreshed from Gibbon.', __CLASS__));
                $clearCache = true;
            }

            if ($lastSettingRefresh !== null && $lastSettingRefresh < strtotime('-30 Days')) {
                $this->installationManager->settings();
                $this->getLogger()->info(sprintf('%s: The settings where refreshed from Gibbon.', __CLASS__));
                $clearCache = true;
            }
            if ($clearCache)
                $this->getInstallationManager()->clearCache();
        }
    }

    /**
     * onRequest
     * @param GetResponseEvent $event
     * @throws \Exception
     */
    public function onRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (mb_strpos(trim($request->getRequestUri(), '/'), '_') === 0)
            return ;
        $install = explode('/', trim($request->getRequestUri(), '/'));
        $install = isset($install[2]) ? $install[2] : '';
        if (in_array($install, ['first-step', 'second-step', 'third-step']))
            return;

        if (! file_exists($this->installationManager->getFile()))
        {
            $response = new RedirectResponse('/en_GB/install/first-step/');
            $event->setResponse($response);
            return ;
        }

        $content = $this->installationManager->getMobileParameters();

        if (empty($content['setting_last_refresh']))
        {
            $response = new RedirectResponse('/'.$content['locale'].'/install/second-step/');
            $event->setResponse($response);
            return ;
        }

        $content['translation_refresh'] = ! empty($content['translation_refresh']) ? $content['translation_refresh'] : 90;

        if (empty($content['translation_last_refresh']))
        {
            $response = new RedirectResponse('/'.$content['locale'].'/install/third-step/');
            $event->setResponse($response);
            return ;
        }

        if (! $event->getRequest()->hasSession()) {
            $session = new Session();
            $session->start();
        }
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @return InstallationManager
     */
    public function getInstallationManager(): InstallationManager
    {
        return $this->installationManager;
    }

    /**
     * @param InstallationManager $installationManager
     * @return SettingListener
     */
    public function setInstallationManager(InstallationManager $installationManager): SettingListener
    {
        $this->installationManager = $installationManager;
        return $this;
    }
}