<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon, Flexible & Open School System
 * Copyright (C) 2010, Ross Parker
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the LICENCE file.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * Gibbon-Mobile
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Listener;

use App\Manager\InstallationManager;
use App\Manager\SettingManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class SettingListener
 * @package App\Listener
 */
class SettingListener implements EventSubscriberInterface
{
    /**
     * @var SettingManager
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
     * @var bool
     */
    private $clearCache = false;

    /**
     * SettingListener constructor.
     * @param InstallationManager $installationManager
     * @param SettingManager|null $manager
     */
    public function __construct(InstallationManager $installationManager, ?SettingManager $manager = null)
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
//            KernelEvents::RESPONSE => ['onResponse', -16],
            KernelEvents::TERMINATE => ['clearCache', -32],
            KernelEvents::REQUEST => ['onRequest', 0],
        ];

        return $listeners;
    }

    /**
     * onResponse
     * @param FilterResponseEvent $event
     * @throws \Exception
     */
    public function onResponse(FilterResponseEvent $event)
    {
        if ($this->manager instanceof SettingManager) {
            $this->manager->saveSettingCache();

            $lastTranslationRefresh = $this->manager->getParameter('translation_last_refresh', null);

            if ($lastTranslationRefresh !== null && $lastTranslationRefresh < strtotime('-'.$this->manager->getParameter('translation_refresh', 90).' Days')) {
                $this->installationManager->translations();
                $this->getLogger()->info(sprintf('%s: The translation files were refreshed from Gibbon.', __CLASS__));
            }
            
            
            $lastSettingRefresh = $this->manager->getParameter('setting_last_refresh', null);

            if ($lastSettingRefresh !== null && $lastSettingRefresh < strtotime('-30 Days')) {
                $this->installationManager->settings();
                $this->getLogger()->info(sprintf('%s: The settings where refreshed from Gibbon.', __CLASS__));
            }
        }

    }

    /**
     * clearCache
     * @param KernelEvent $event
     */
    public function clearCache(KernelEvent $event)
    {
        if ($this->clearCache) {
            $request = $event->getRequest();
            if ($request->get('_route') === 'install_first_step') {
                if ($request->hasSession())
                    $request->getSession()->invalidate();
                $this->installationManager->getFilesystem()->remove($this->installationManager->getKernel()->getCacheDir());
                die();
            }
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