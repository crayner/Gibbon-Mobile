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
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 19/02/2019
 * Time: 10:11
 */
namespace App\Manager;

use App\Command\EnvironmentInstallCommand;
use App\Entity\I18n;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class InstallationManager
 * @package App\Manager
 */
class InstallationManager
{
    const METHOD_COPY = 'copy';
    const METHOD_ABSOLUTE_SYMLINK = 'absolute symlink';
    const METHOD_RELATIVE_SYMLINK = 'relative symlink';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return InstallationManager
     */
    public function setLogger(LoggerInterface $logger): InstallationManager
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @return KernelInterface
     */
    public function getKernel(): KernelInterface
    {
        return $this->kernel;
    }

    /**
     * @param KernelInterface $kernel
     * @return InstallationManager
     */
    public function setKernel(KernelInterface $kernel): InstallationManager
    {
        $this->kernel = $kernel;
        return $this;
    }

    /**
     * @var SettingManager
     */
    private $settingManager;

    /**
     * getSettingManager
     * @return SettingManager
     */
    public function getSettingManager(): SettingManager
    {
        return $this->settingManager;
    }

    /**
     * setSettingManager
     * @param SettingManager $settingManager
     * @return InstallationManager
     */
    public function setSettingManager(SettingManager $settingManager): InstallationManager
    {
        $this->settingManager = $settingManager;
        return $this;
    }

    /**
     * getSettingManager
     * @return SettingManager
     */
    public function getMessageManager(): MessageManager
    {
        return $this->getSettingManager()->getMessageManager();
    }

    /**
     * settings
     * @return int
     */
    public function settings()
    {
        $this->getMessageManager()->addMessage('success', sprintf('File: %s', $this->getFile()));
        $this->logger->info(sprintf('%s: File: %s', __CLASS__, $this->getFile()));
        $content = $this->getMobileParameters();

        $gibbonRoot = $content['gibbon_document_root'];
        $this->getMessageManager()->addMessage('success', sprintf('Gibbon Document Root: %s', $gibbonRoot));
        $this->logger->info(sprintf('%s: Gibbon Document Root: %s', __CLASS__, $gibbonRoot));

        $fileSystem = new Filesystem();
        if (! $fileSystem->exists($this->file))
            $fileSystem->copy($this->file.'.dist', $this->file, false);

        // now build .env.local file for the mailer
        if ($this->getSettingManager()->getSettingByScopeAsBoolean('System', 'enableMailerSMTP', 'N')) {

            if ($gibbonRoot !== $content['gibbon_document_root'])
            {
                $this->getMessageManager()->addMessage('error', sprintf('The database absolute path %s does not equal the config path %s', $gibbonRoot, $content['gibbon_document_root']));
                $this->logger->error(sprintf('%s: The database absolute path %s does not equal the config path %s', __CLASS__, $gibbonRoot, $content['gibbon_document_root']));
                return 2;
            }

            $content['mailer_host'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPHost', null);
            $content['mailer_transport'] = 'smtp';
            $content['mailer_auth_mode'] = null;
            if (strpos($content['mailer_host'], 'gmail') !== false)
                $content['mailer_transport'] = 'gmail';
            if ($content['mailer_transport'] === 'smtp') {
                $content['mailer_port'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPPort', null);
                $content['mailer_encryption'] = null;
                if ($content['mailer_port'] === '465')
                    $content['mailer_encryption'] = 'ssl';
                if ($content['mailer_port'] === '587')
                    $content['mailer_encryption'] = 'tls';
            }
            $content['mailer_user'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPUsername', null);
            $content['mailer_password'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPPassword', null);
            $content['mailer_spool'] = ['type' => 'memory'];


            //$fileSystem->dumpFile($this->file, Yaml::dump($content,8));
            $this->getMessageManager()->addMessage('success','Email settings have been copied from the Gibbon Setup');
            $this->logger->info(sprintf('%s: Email settings have been copied from the Gibbon Setup.', __CLASS__));
        } else {

            $content['mailer_host'] = null;
            $content['mailer_transport'] = null;
            $content['mailer_auth_mode'] = null;
            $content['mailer_transport'] = null;
            $content['mailer_port'] = null;
            $content['mailer_encryption'] = null;
            $content['mailer_user'] = null;
            $content['mailer_password'] = null;
            $content['mailer_spool'] = ['type' => 'memory'];


            //$fileSystem->dumpFile($this->file, Yaml::dump($content,8));
            $this->getMessageManager()->addMessage('success', 'Email settings have been set as default and turned off.');
            $this->logger->info(sprintf('%s: Email settings have been set as default and turned off.', __CLASS__));
        }

        $content['cookie_lifetime'] = $this->getSettingManager()->getSettingByScopeAsInteger('System', 'sessionDuration', 1200);
        $content['google_client_id'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'googleClientID', '');
        $content['google_secret'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'googleClientSecret', '');
        $content['timezone'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'timezone', 'UTC');
        $content['gibbon_document_root'] = $gibbonRoot;
        $content['gibbon_host_url'] = str_replace("\r\n", '', $this->getSettingManager()->getSettingByScopeAsString('System', 'absoluteURL')) . '/';
        $content['mailer_sender_address'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'organisationEmail', null);
        $content['mailer_sender_name'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'organisationName', null);
        $content['locale'] = $this->getSettingManager()->getRepository(I18n::class)->createQueryBuilder('i')
            ->where('i.systemDefault = :yes')
            ->setParameter('yes', 'Y')
            ->select('i.code')
            ->getQuery()
            ->getSingleScalarResult() ?: 'en_GB';

        $content['setting_last_refresh'] = strtotime('now');
        $content['installation_progress'] = 'settings';
        $this->setMobileParameters($content);
        $this->getMessageManager()->addMessage('success', 'Additional Environmental settings have been set into the Gibbon-Responsive framework.');
        $this->logger->info(sprintf('%s: Additional Environmental settings have been set into the Gibbon-Responsive framework.', __CLASS__.':'.__LINE__), $this->content);

        $file = $this->getKernel()->getProjectDir(). DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build' ;

        $fileSystem->remove($file);

        $fileSystem->mirror($this->getKernel()->getProjectDir(). DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'dist', $file);

        $this->getMessageManager()->addMessage('success', 'Assets have been copied from dist to build directory!');
        $this->logger->info(sprintf('%s: Assets have been copied from dist to build directory!', __CLASS__));

        return 0;
    }

    /**
     * @var string
     */
    private $file;

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file = $this->file ?: $this->getKernel()->getProjectDir(). DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_responsive.yaml';
    }

    /**
     * translations
     * @return int
     * @throws \Exception
     */
    public function translations()
    {
        $message = 'Translation Transfer';

        $this->getLogger()->info($message);

        $sourceDir = $this->getGibbonDocumentRoot();

        if (!is_dir($sourceDir)) {
            $this->logger->error(sprintf('The source directory "%s" does not exist. Set the "gibbon_document_root" parameter in the "gibbon_responsive.yaml"' , $this->getGibbonDocumentRoot()));
            throw new \InvalidArgumentException(sprintf('The source directory "%s" does not exist. Set the "gibbon_document_root" parameter in the "gibbon_responsive.yaml"' , $this->getGibbonDocumentRoot()));
        }
        $sourceDir = rtrim($sourceDir, "\\/") . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR;
        if (!is_dir($sourceDir)) {
            $this->getLogger()->error(sprintf('The source directory "%s" does not exist.', $sourceDir));
            throw new \InvalidArgumentException(sprintf('The source directory "%s" does not exist.', $sourceDir));
        }

        $this->getLogger()->info($message);



        $this->getFinder()->directories()->in($sourceDir);

        $expectedMethod = self::METHOD_RELATIVE_SYMLINK;

        $rows = false;
        $copyUsed = false;
        $exitCode = 0;

        $targetDir = $this->getKernel()->getProjectDir(). DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR;

        $this->getFilesystem()->mkdir(\dirname($targetDir), 0755);

        $method = $expectedMethod;

        foreach($this->getFinder() as $dir) {

            $locale = $dir->getBasename();
            if ($locale === 'LC_MESSAGES')
                continue;
            $source = $dir->getPathname() . DIRECTORY_SEPARATOR . 'LC_MESSAGES' . DIRECTORY_SEPARATOR ;

            if (! file_exists($source)) {
                $this->getMessageManager()->add('warning', sprintf('%s: The translation file is locked for locale %s', __CLASS__, $locale));
            } else {
                $finder = new Finder();

                $finder->name("/(\.mo$)|(\.po$)/")->in($source);

                foreach($finder as $file) {
                    $source = $file->getPathname();
                    $target = $targetDir . 'messages.' . $locale . '.' . $file->getExtension();

                    try {
                        if ($method === self::METHOD_RELATIVE_SYMLINK)
                            $method = $this->relativeSymlinkWithFallback($source,$target);
                        elseif ($method === self::METHOD_ABSOLUTE_SYMLINK)
                            $method = $this->relativeSymlinkWithFallback($source,$target);
                        else
                            $method = $this->hardCopy($source, $target);

                        if (self::METHOD_COPY === $method) {
                            $copyUsed = true;
                        }

                        if ($method === $expectedMethod) {
                            $this->getMessageManager()->add('success' , sprintf('Successful Translation Transfer for %s using method %s', $target, $method));
                            $this->logger->info(sprintf('%s: Successful Translation Transfer for %s using method %s', __CLASS__, $target, $method));
                            $rows = true;
                        } else {
                            $this->getMessageManager()->add('warning' , sprintf('Warning Translation Transfer for %s using method %s', $target, $method));
                            $this->logger->warning(sprintf('%s: Warning Translation Transfer for %s using method %s', __CLASS__, $target, $method));
                            $rows = true;
                        }
                    } catch (\Exception $e) {
                        $exitCode = 1;
                        $this->getMessageManager()->add('error' , sprintf('Error Translation Transfer for %s using method %s. Error %s', $target, $method, $e->getMessage()));
                        $this->logger->error(sprintf('%s: Error Translation Transfer for %s using method %s. Error %s', __CLASS__, $target, $method, $e->getMessage()));
                    }
                }
            }
        }

        if (0 !== $exitCode) {
            $this->getMessageManager()->add('error', 'Some errors occurred while installing translations.');
            $this->logger->error(sprintf('%s: Some errors occurred while installing translations.', __CLASS__));
        } else {
            if ($copyUsed) {
                $this->getMessageManager()->add('info', 'Some translations were installed via copy. If you make changes to these translations in Gibbon you have to run this command again.');
                $this->logger->info(sprintf('%s: Some translations were installed via copy. If you make changes to these translations in Gibbon you have to run this command again.', __CLASS__));
            }
            $this->getMessageManager()->add('success', ($rows ? 'All translations were successfully installed.' : 'No translations were provided by Gibbon.'));
            $this->logger->info(sprintf($rows ? '%s: All translations were successfully installed.' : '%s: No translations were provided by Gibbon.', __CLASS__));

            $this->setParameter('translation_last_refresh', strtotime('now'));
            $this->setParameter('installation_progress', 'complete');
        }

        return $exitCode;
    }

    /**
     * @var string
     */
    private $gibbonDocumentRoot;

    /**
     * getGibbonDocumentRoot
     * @return string
     * @throws \Exception
     */
    private function getGibbonDocumentRoot(): string 
    {
        return $this->gibbonDocumentRoot = $this->gibbonDocumentRoot ?: $this->getSettingManager()->getSettingByScopeAsString('System', 'absolutePath') ?: '';
    }

    /**
     * @var Finder
     */
    private $finder;

    /**
     * getFinder
     * @return Finder
     */
    private function getFinder(): Finder
    {
        return $this->finder = $this->finder ?: new Finder();
    }

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * getFilesystem
     * @return Filesystem
     */
    public function getFilesystem(): FileSystem
    {
        return $this->filesystem = $this->filesystem ?: new Filesystem();
    }

    /**
     * relativeSymlinkWithFallback
     *
     * @param string $origin
     * @param string $target
     * @return string
     */
    private function relativeSymlinkWithFallback(string $origin, string $target): string
    {
        try {
            $this->symlink($origin, $target, true);
            $method = self::METHOD_RELATIVE_SYMLINK;
        } catch (IOException $e) {
            $method = $this->absoluteSymlinkWithFallback($origin, $target);
        }

        return $method;
    }

    /**
     * absoluteSymlinkWithFallback
     *
     * @param string $origin
     * @param string $target
     * @return string
     */
    private function absoluteSymlinkWithFallback(string $origin, string $target): string
    {
        try {
            $this->symlink($origin, $target, false);
            $method = self::METHOD_ABSOLUTE_SYMLINK;
        } catch (IOException $e) {
            // fall back to copy
            $this->logger->info(sprintf('%s: Files were copied as symlink was not available.', __CLASS__, $target));
            $method = $this->hardCopy($origin, $target);
        }

        return $method;
    }

    /**
     * symlink
     *
     * @param string $origin
     * @param string $target
     * @param bool $relative
     */
    private function symlink(string $origin, string $target, bool $relative = false)
    {
        if ($relative) {
            $this->filesystem->copy($origin, $target, true);
            $origin = $this->filesystem->makePathRelative($origin, realpath($target));
        }
        $this->filesystem->symlink($origin, $target);
        if (!file_exists($target)) {
            $this->logger->error(sprintf('%s: Symbolic link "%s" was created but appears to be broken.', __CLASS__, $target));
            throw new IOException(sprintf('Symbolic link "%s" was created but appears to be broken.', $target), 0, null, $target);
        }
    }

    /**
     * hardCopy
     *
     * @param string $origin
     * @param string $target
     * @return string
     */
    private function hardCopy(string $origin, string $target): string
    {
        $this->filesystem->copy($origin, $target, true);

        return self::METHOD_COPY;
    }

    /**
     * @var array
     */
    private $content = [];

    /**
     * getMobileParameters
     * @return array
     */
    public function getMobileParameters(): array 
    {
        $this->content = $this->content ?: Yaml::parse(file_get_contents($this->getFile()));
        $this->content = isset($this->content['parameters']) ? $this->content['parameters'] : $this->content ;
        return $this->content = $this->content ?: [];
    }

    /**
     * setMobileParameters
     * @param array $content
     * @return InstallationManager
     * @throws LogicException
     */
    public function setMobileParameters(array $content = []): InstallationManager
    {
        if (isset($content['parameters']))
            throw new LogicException('The parameter key should not be passed to setMobileParameters');
        if (! empty($content))
            $this->content = $content;
        $content = [];
        $content['parameters'] = $this->content;
        if (isset($content['parameters']['parameters']))
            unset($content['parameters']['parameters']);
        $this->getFilesystem()->dumpFile($this->getFile(), Yaml::dump($content, 8));
        return $this;
    }

    /**
     * setParameter
     * @param string $name
     * @param mixed $value
     */
    public function setParameter(string $name, $value): InstallationManager
    {
        $content = $this->getMobileParameters();
        $content[$name] = $value;
        $this->getLogger()->debug(sprintf('The Parameter "%s" was set to "%s"', $name, strval($value)));
        return $this->setMobileParameters($content);
    }

    /**
     * assetsinstall
     */
    public function assetsinstall()
    {
        $rows = false;
        $copyUsed = false;
        $exitCode = 0;
        $validAssetDirs = [];
        $expectedMethod = self::METHOD_RELATIVE_SYMLINK;
        $kernel = $this->getSettingManager()->getContainer()->get('kernel');
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
     * writeParametersFile
     * @return BufferedOutput
     */
    public function writeParametersFile()
    {
        if (! file_exists($this->getFile()))
        {
            $app = new EnvironmentInstallCommand($this);

            $input = new ArrayInput(
                [],
                $app->getDefinition()
            );

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();

            $app->executeCommand($input, $output, $this->getKernel());
            // return the output, don't use if you used NullOutput()

            $content = [];
            $content[] = '# Auto-generated by Installation routines within the kernel.';
            $content[] = '# on '.date('jS M/Y H:i:s');
            $content[] = 'APP_ENV=prod';
            $content[] = 'APP_SECRET='.substr(str_replace('.', '', uniqid('') . uniqid('')), -32);

            file_put_contents($this->getKernel()->getProjectDir() . DIRECTORY_SEPARATOR . '.env.local', implode("\r\n", $content));

            return $output->fetch();
        }
    }

    /**
     * getMobileParameter
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function getMobileParameter(string $name, $default = null)
    {
        if ($this->settingManager instanceof SettingManager)
            return $this->getSettingManager()->getParameter($name, $default);
        $content = $this->getMobileParameters();
        if (isset($content[$name]))
            return $content[$name];
        return $default;
    }

    /**
     * clearCache
     */
    public function clearCache(): void
    {
        if ($this->settingManager instanceof SettingManager)
            $cacheDir = $this->getSettingManager()->getContainer()->get('kernel')->getCacheDir();
        else
            $cacheDir = '../../var/cache/';
        if (! realpath($cacheDir)) {
            $this->getLogger()->warning('The cache could not be cleared.', [$cacheDir, realpath($cacheDir)]);
            return ;
        }
        ini_set('max_execution_time', 120);
        $fs = new Filesystem();
        try {
            sleep(1);
            $fs->remove($cacheDir);
        } catch (IOException $e) {
            $this->getLogger()->warning('The cache could not be removed.', [$cacheDir, realpath($cacheDir)]);
            $this->clearCache();
            return ;
        }

        $this->getLogger()->warning('The cache was cleared.');
        return ;
    }
}