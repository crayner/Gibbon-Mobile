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

use App\Manager\SettingManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
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
     * SettingListener constructor.
     * @param ContainerInterface $container
     * @param LoggerInterface $logger
     * @param SettingManager|null $manager
     */
    public function __construct(ContainerInterface $container, LoggerInterface $logger, ?SettingManager $manager = null)
    {
        $this->manager = $manager;
        $this->container = $container;
        $this->logger = $logger->withName('setting');
    }

    /**
     * getSubscribedEvents
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $listeners = [
            KernelEvents::RESPONSE => 'onResponse',
            KernelEvents::REQUEST => 'onRequest',
        ];

        return $listeners;
    }

    /**
     * onResponse
     * @param KernelEvent $event
     * @throws \Exception
     */
    public function onResponse()
    {
        if ($this->manager instanceof SettingManager) {
            $this->manager->saveSettingCache();

            $lastTranslation = $this->manager->getSettingByScopeAsDate('Mobile', 'translationTransferDate');

            if ($lastTranslation === false || ! $lastTranslation instanceof \DateTime ||
                $lastTranslation->diff(new \DateTime('now'), true )->format('%a') > $this->manager->getParameter('translation_refresh', 90))
            {
                $application = new Application($this->getContainer()->get('kernel'));
                $application->setAutoExit(false);

                $input = new ArrayInput(array(
                    'command' => 'translation:install',
                    // (optional) define the value of command arguments
                    '--relative' => '--relative',
                ));

                // You can use NullOutput() if you don't need the output
                $output = new BufferedOutput();
                $result = $application->run($input, $output);

                // return the output, don't use if you used NullOutput()
                if ($result !== 0)
                    trigger_error($output->fetch(), E_USER_ERROR);

                $output->fetch();

                $input = new ArrayInput(array(
                    'command' => 'setting:install',
                ));

                // You can use NullOutput() if you don't need the output
                $output = new BufferedOutput();
                $result = $application->run($input, $output);

                // return the output, don't use if you used NullOutput()
                if ($result !== 0)
                    trigger_error($output->fetch(), E_USER_ERROR);

                $output->fetch();

                $this->logger->notice('Translation and Settings were updated.');
            }
        }
    }

    /**
     * onRequest
     * @param KernelEvent $event
     * @throws \Exception
     */
    public function onRequest(KernelEvent $event)
    {
        if (! $event->getRequest()->hasSession()) {
            $session = new Session();
            $session->start();
        }
        $file = __DIR__ . DIRECTORY_SEPARATOR .'..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon.yaml';
        if (realpath($file) &&! file_exists($file))
            self::onResponse();
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}