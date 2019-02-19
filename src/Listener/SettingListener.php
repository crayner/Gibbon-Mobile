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

use App\Command\EnvironmentInstallCommand;
use App\Manager\InstallationManager;
use App\Manager\SettingManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
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
     * SettingListener constructor.
     * @param ContainerInterface $container
     * @param LoggerInterface $logger
     * @param SettingManager|null $manager
     */
    public function __construct(ContainerInterface $container, ?SettingManager $manager = null)
    {
        $this->manager = $manager;
        $this->container = $container;
        $this->logger = $container->get('monolog.logger.setting');
        $this->filesystem = new Filesystem();
        $this->installationManager = new InstallationManager();
        $this->installationManager->setSettingManager($manager)
            ->setKernel($container->get('kernel'))
            ->setLogger($this->logger);
        $this->clearCache = false;
    }

    /**
     * getSubscribedEvents
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $listeners = [
            KernelEvents::RESPONSE => ['onResponse', -16],
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
        $parameters = $this->installationManager->getMobileParameters();
        $request = $event->getRequest();
        if ($request->get('_route') === 'login' && $parameters['installation_required'] && ! empty($parameters['setting_last_refresh']) && ! empty($parameters['translation_last_refresh'])) {
            $this->installationManager->setParameter('installation_required', false);
            $this->installationManager->getFilesystem()->remove($this->installationManager->getKernel()->getCacheDir());
            $response = new RedirectResponse('/'. $parameters['locale'].'/login/');
            $event->setResponse($response);
        }
    }
    /**
     * onRequest
     * @param GetResponseEvent $event
     * @return int
     * @throws \Exception
     */
    public function onRequest(GetResponseEvent $event)
    {
        if (! file_exists($this->installationManager->getFile()))
        {
            $app = new EnvironmentInstallCommand();
            $kernel = $this->getContainer()->get('kernel');

            $input = new ArrayInput(
                [],
                $app->getDefinition()
            );

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();

            $app->executeCommand($input, $output, $kernel);
            // return the output, don't use if you used NullOutput()
            $output->fetch();

            $response = new RedirectResponse('/');
            $event->setResponse($response);
        }

        $content = $this->installationManager->getMobileParameters();

        if (empty($content['setting_last_refresh']))
        {
            $this->installationManager->settings();
            $this->getLogger()->info(sprintf('%s: The settings where copied from Gibbon.', __CLASS__));

            $response = new RedirectResponse('/');
            $event->setResponse($response);
        }

        $content['translation_refresh'] = ! empty($content['translation_refresh']) ? $content['translation_refresh'] : 90;

        if (empty($content['translation_last_refresh']))
        {
            $this->installationManager->translations();
            $this->installationManager->assetsinstall();

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
}