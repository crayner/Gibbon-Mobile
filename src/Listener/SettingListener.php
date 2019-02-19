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
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
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
     * @var Filesystem 
     */
    private $filesystem;

    /**
     * @var InstallationManager
     */
    private $installationManager;

    const METHOD_COPY = 'copy';
    const METHOD_ABSOLUTE_SYMLINK = 'absolute symlink';
    const METHOD_RELATIVE_SYMLINK = 'relative symlink';

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
                $content = Yaml::parse(file_get_contents($this->getFile()));
                $content['parameters']['translation_last_refresh'] = strtotime('now');
                file_put_contents($this->getFile(), Yaml::dump($content, 8));
                $this->getLogger()->info(sprintf('%s: The translation files were refreshed from Gibbon.', __CLASS__));
            }
            
            
            $lastSettingRefresh = $this->manager->getParameter('setting_last_refresh', null);

            if ($lastSettingRefresh !== null && $lastSettingRefresh < strtotime('-30 Days')) {
                $this->installationManager->settings();

                $content = Yaml::parse(file_get_contents($this->getFile()));
                $content['parameters']['setting_last_refresh'] = strtotime('now');
                file_put_contents($this->getFile(), Yaml::dump($content, 8));
                $this->getLogger()->info(sprintf('%s: The settings where refreshed from Gibbon.', __CLASS__));
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
        if (! file_exists($this->getFile()))
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

        $content = Yaml::parse(file_get_contents($this->getFile()));

        if (empty($content['parameters']['setting_last_refresh'])) {
            $this->installationManager->settings();
            $content = Yaml::parse(file_get_contents($this->getFile()));
            $content['parameters']['setting_last_refresh'] = strtotime('now');
            file_put_contents($this->getFile(), Yaml::dump($content, 8));
            $this->getLogger()->info(sprintf('%s: The settings where copied from Gibbon.', __CLASS__));
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
            file_put_contents($this->getFile(), Yaml::dump($content, 8));
            $this->getLogger()->info(sprintf('%s: The translation files were copied from Gibbon', __CLASS__));

            $this->assetsinstall();
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
     * assetsinstall
     */
    private function assetsinstall()
    {
        $rows = false;
        $copyUsed = false;
        $exitCode = 0;
        $validAssetDirs = [];
        $expectedMethod = self::METHOD_RELATIVE_SYMLINK;
        $kernel = $this->getContainer()->get('kernel');
        $bundlesDir = $kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'bundles' . DIRECTORY_SEPARATOR;

        /** @var BundleInterface $bundle */
        foreach ($kernel->getBundles() as $bundle) {
            if (!is_dir($originDir = $bundle->getPath().'/Resources/public')) {
                continue;
            }

            $assetDir = preg_replace('/bundle$/', '', strtolower($bundle->getName()));
            $targetDir = $bundlesDir.$assetDir;
            $validAssetDirs[] = $assetDir;

            $message = $bundle->getName();

            try {
                $this->filesystem->remove($targetDir);

                if (self::METHOD_RELATIVE_SYMLINK === $expectedMethod) {
                    $method = $this->relativeSymlinkWithFallback($originDir, $targetDir);
                } elseif (self::METHOD_ABSOLUTE_SYMLINK === $expectedMethod) {
                    $method = $this->absoluteSymlinkWithFallback($originDir, $targetDir);
                } else {
                    $method = $this->hardCopy($originDir, $targetDir);
                }

                if (self::METHOD_COPY === $method) {
                    $copyUsed = true;
                }

                if ($method === $expectedMethod) {
                    $this->logger->info(sprintf('%s: OK: $s used method %s', __CLASS__, $message, $method));
                    $rows = true;
                } else {
                    $this->logger->warning(sprintf('%s: WARNING: %s used method \'%s\'', __CLASS__, $message, $method));
                    $rows = true;
                }
            } catch (\Exception $e) {
                $exitCode = 1;
                $this->logger->error(sprintf('%s: ERROR: $s tried to used method %s, but failt with error: %s', __CLASS__, $message, $method, $e->getMessage()));
            }
        }
        // remove the assets of the bundles that no longer exist
        if (is_dir($bundlesDir)) {
            $dirsToRemove = Finder::create()->depth(0)->directories()->exclude($validAssetDirs)->in($bundlesDir);
            if ($dirsToRemove->count() > 0) {
                foreach($dirsToRemove->getIterator() as $item)
                    $this->logger->info(sprintf('%s: Bundle \'%s\' is no longer required.', __CLASS__, $item->getFilename()));
                $this->filesystem->remove($dirsToRemove);
            }
        }

        if (0 !== $exitCode) {
            $this->logger->error(sprintf('%s: Some errors occurred while installing assets.', __CLASS__));
        } else {
            if ($copyUsed) {
                $this->logger->warning(sprintf('%s: Some assets were installed via copy. If you make changes to these assets you have to run this command again.', __CLASS__));
            }
            $this->logger->warning(sprintf(($rows ? '%s: All assets were successfully installed.' : '%s: No assets were provided by any bundle.'), __CLASS__));
        }
    }

    /**
     * Try to create relative symlink.
     *
     * Falling back to absolute symlink and finally hard copy.
     */
    private function relativeSymlinkWithFallback(string $originDir, string $targetDir): string
    {
        try {
            $this->symlink($originDir, $targetDir, true);
            $method = self::METHOD_RELATIVE_SYMLINK;
        } catch (IOException $e) {
            $method = $this->absoluteSymlinkWithFallback($originDir, $targetDir);
        }

        return $method;
    }

    /**
     * Try to create absolute symlink.
     *
     * Falling back to hard copy.
     */
    private function absoluteSymlinkWithFallback(string $originDir, string $targetDir): string
    {
        try {
            $this->symlink($originDir, $targetDir);
            $method = self::METHOD_ABSOLUTE_SYMLINK;
        } catch (IOException $e) {
            // fall back to copy
            $method = $this->hardCopy($originDir, $targetDir);
        }

        return $method;
    }

    /**
     * Creates symbolic link.
     *
     * @throws IOException if link can not be created
     */
    private function symlink(string $originDir, string $targetDir, bool $relative = false)
    {
        if ($relative) {
            $this->filesystem->mkdir(\dirname($targetDir));
            $originDir = $this->filesystem->makePathRelative($originDir, realpath(\dirname($targetDir)));
        }
        $this->filesystem->symlink($originDir, $targetDir);
        if (!file_exists($targetDir)) {
            throw new IOException(sprintf('Symbolic link "%s" was created but appears to be broken.', $targetDir), 0, null, $targetDir);
        }
    }

    /**
     * Copies origin to target.
     */
    private function hardCopy(string $originDir, string $targetDir): string
    {
        $this->filesystem->mkdir($targetDir, 0777);
        // We use a custom iterator to ignore VCS files
        $this->filesystem->mirror($originDir, $targetDir, Finder::create()->ignoreDotFiles(false)->in($originDir));

        return self::METHOD_COPY;
    }

    /**
     * getFile
     * @return string
     */
    public function getFile(): string
    {
        return $this->file = $this->file ?: $this->installationManager->getFile();
    }
}