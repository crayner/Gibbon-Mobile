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
use App\Manager\SettingManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Yaml\Yaml;

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
     * @var string
     */
    private $file;

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
        $this->file = __DIR__ . DIRECTORY_SEPARATOR .'..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml';
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
     * @param FilterResponseEvent $event
     * @throws \Exception
     */
    public function onResponse(FilterResponseEvent $event)
    {
        if ($this->manager instanceof SettingManager) {
            $this->manager->saveSettingCache();

            $lastTranslationRefresh = $this->manager->getParameter('translation_last_refresh', null);

            if ($lastTranslationRefresh !== null && $lastTranslationRefresh < strtotime('-'.$this->manager->getParameter('translation_refresh', 90).' Days')) {
                $application = new Application($this->getContainer()->get('kernel'));
                $application->setAutoExit(false);

                $input = new ArrayInput(array(
                    'command' => 'gibbon:translation:install',
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
                $content = Yaml::parse(file_get_contents($this->file));
                $content['parameters']['translation_last_refresh'] = strtotime('now');
                file_put_contents($this->file, Yaml::dump($content, 8));
                $this->getLogger()->info('The translation files were refreshed from Gibbon.');
            }
            
            
            $lastSettingRefresh = $this->manager->getParameter('setting_last_refresh', null);

            if ($lastSettingRefresh !== null && $lastSettingRefresh < strtotime('-30 Days')) {
                $input = new ArrayInput(array(
                    'command' => 'gibbon:setting:install',
                ));

                // You can use NullOutput() if you don't need the output
                $output = new BufferedOutput();
                $result = $application->run($input, $output);

                // return the output, don't use if you used NullOutput()
                if ($result !== 0)
                    trigger_error($output->fetch(), E_USER_ERROR);

                $output->fetch();

                $content = Yaml::parse(file_get_contents($this->file));
                $content['parameters']['setting_last_refresh'] = strtotime('now');
                file_put_contents($this->file, Yaml::dump($content, 8));
                $this->getLogger()->info('The settings where refreshed from Gibbon.');
            }
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
        if (! file_exists($this->file))
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

            $content = [];
            $content[] = '# Auto-generated by Installation routines within the kernel.';
            $content[] = '# on '.date('jS M/Y');
            $content[] = 'APP_ENV=prod';
            $content[] = 'APP_SECRET='.substr(str_replace('.', '', uniqid('',true) . uniqid('',true)), -32);

            file_put_contents($kernel->getProjectDir() . DIRECTORY_SEPARATOR . '.env.local', implode("\r\n", $content));

            $response = new RedirectResponse('/');

            $event->setResponse($response);
        }

        $this->file = realpath($this->file);
        $content = Yaml::parse(file_get_contents($this->file));


        if (empty($content['parameters']['setting_last_refresh'])) {

            $application = new Application($this->getContainer()->get('kernel'));
            $application->setAutoExit(false);
            ini_set('max_execution_time', 30);
            $input = new ArrayInput(
                [
                    'command' => 'gibbon:setting:install',
                ]
            );

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $result = $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            if ($result !== 0) {
                dd($output);
                return $result;
            }

            $content['parameters']['setting_last_refresh'] = strtotime('now');
            file_put_contents($this->file, Yaml::dump($content, 8));
            $this->getLogger()->info('The settings where copied from Gibbon.');
        }

        $content['parameters']['translation_refresh'] = ! empty($content['parameters']['translation_refresh']) ? $content['parameters']['translation_refresh'] : 90;

        if (empty($content['parameters']['translation_last_refresh']))
        {
            $application = new Application($this->getContainer()->get('kernel'));
            $application->setAutoExit(false);

            $input = new ArrayInput(
                [
                    'command' => 'gibbon:translation:install',
                ]
            );

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $result = $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            if ($result !== 0) {
                dd($output);
                return $result;
            }
            $content['parameters']['translation_last_refresh'] = strtotime('now');
            file_put_contents($this->file, Yaml::dump($content, 8));
            $this->getLogger()->info('The translation files were copied from Gibbon');

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