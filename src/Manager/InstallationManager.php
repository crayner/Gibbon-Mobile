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
 * User: craig
 * Date: 19/02/2019
 * Time: 10:11
 */
namespace App\Manager;

use App\Entity\I18n;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

class InstallationManager
{
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
        $content = Yaml::parse(file_get_contents($this->getFile()));

        $gibbonRoot = $content['parameters']['gibbon_document_root'];
        $this->getMessageManager()->addMessage('success', sprintf('Gibbon Document Root: %s', $gibbonRoot));
        $this->logger->info(sprintf('%s: Gibbon Document Root: %s', __CLASS__, $gibbonRoot));

        $fileSystem = new Filesystem();
        if (! $fileSystem->exists($this->file))
            $fileSystem->copy($this->file.'.dist', $this->file, false);

        $config = realpath(rtrim($gibbonRoot, '\\/') . DIRECTORY_SEPARATOR . 'config.php');
        if ($config === false) {
            $this->getMessageManager()->addMessage('error', sprintf('The Gibbon config.php file was not found at "%s"', $config));
            $this->logger->error(sprintf('%S: The Gibbon config.php file was not found at "%s"', __CLASS__, $config));
            return 1;
        } else {
            $this->getMessageManager()->addMessage('success', sprintf('The Gibbon config.php file was found at "%s"', $config));
            $this->logger->info(sprintf('%s: The Gibbon config.php file was found at "%s"', __CLASS__, $config));
            // now build .env.local file for the mailer
            if ($this->getSettingManager()->getSettingByScopeAsBoolean('System', 'enableMailerSMTP', 'N')) {

                if ($gibbonRoot !== $content['parameters']['gibbon_document_root'])
                {
                    $this->getMessageManager()->addMessage('error', sprintf('The database absolute path %s does not equal the config path %s', $gibbonRoot, $content['parameters']['gibbon_document_root']));
                    $this->logger->error(sprintf('%s: The database absolute path %s does not equal the config path %s', __CLASS__, $gibbonRoot, $content['parameters']['gibbon_document_root']));
                    return 2;
                }

                $content['parameters']['mailer_host'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPHost', null);
                $content['parameters']['mailer_transport'] = 'smtp';
                $content['parameters']['mailer_auth_mode'] = null;
                if (strpos($content['parameters']['mailer_host'], 'gmail') !== false)
                    $content['parameters']['mailer_transport'] = 'gmail';
                if ($content['parameters']['mailer_transport'] === 'smtp') {
                    $content['parameters']['mailer_port'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPPort', null);
                    $content['parameters']['mailer_encryption'] = null;
                    if ($content['parameters']['mailer_port'] === '465')
                        $content['parameters']['mailer_encryption'] = 'ssl';
                    if ($content['parameters']['mailer_port'] === '587')
                        $content['parameters']['mailer_encryption'] = 'tls';
                }
                $content['parameters']['mailer_user'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPUsername', null);
                $content['parameters']['mailer_password'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPPassword', null);
                $content['parameters']['mailer_spool'] = ['type' => 'memory'];


                //$fileSystem->dumpFile($this->file, Yaml::dump($content,8));
                $this->getMessageManager()->addMessage('success','Email settings have been copied from the Gibbon Setup');
                $this->logger->info(sprintf('%s: Email settings have been copied from the Gibbon Setup.', __CLASS__));
            } else {
                $content = Yaml::parse(file_get_contents($this->file));

                $content['parameters']['mailer_host'] = null;
                $content['parameters']['mailer_transport'] = null;
                $content['parameters']['mailer_auth_mode'] = null;
                $content['parameters']['mailer_transport'] = null;
                $content['parameters']['mailer_port'] = null;
                $content['parameters']['mailer_encryption'] = null;
                $content['parameters']['mailer_user'] = null;
                $content['parameters']['mailer_password'] = null;
                $content['parameters']['mailer_spool'] = ['type' => 'memory'];


                //$fileSystem->dumpFile($this->file, Yaml::dump($content,8));
                $this->getMessageManager()->addMessage('success', 'Email settings have been set as default and turned off.');
                $this->logger->info(sprintf('%s: Email settings have been set as default and turned off.', __CLASS__));
            }

            $content['parameters']['cookie_lifetime'] = $this->getSettingManager()->getSettingByScopeAsInteger('System', 'sessionDuration', 1200);
            $content['parameters']['google_client_id'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'googleClientID', '');
            $content['parameters']['google_secret'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'googleClientSecret', '');
            $content['parameters']['timezone'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'timezone', 'UTC');
            $content['parameters']['gibbon_document_root'] = $gibbonRoot;
            $content['parameters']['gibbon_host_url'] = str_replace("\r\n", '', $this->getSettingManager()->getSettingByScopeAsString('System', 'absoluteURL')) . '/';
            $content['parameters']['mailer_sender_address'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'organisationEmail', null);
            $content['parameters']['mailer_sender_name'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'organisationName', null);
            $content['parameters']['locale'] = $this->getSettingManager()->getRepository(I18n::class)->createQueryBuilder('i')
                ->where('i.systemDefault = :yes')
                ->setParameter('yes', 'Y')
                ->select('i.code')
                ->getQuery()
                ->getSingleScalarResult() ?: 'en_GB';

            $fileSystem->dumpFile($this->file, Yaml::dump($content, 8));
            $this->getMessageManager()->addMessage('success', 'Environmental settings have been set into the Gibbon-Mobile framework.');
            $this->logger->info(sprintf('%s: Environmental settings have been set into the Gibbon-Mobile framework.', __CLASS__.':'.__LINE__), $content);
        }

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
        return $this->file = $this->file ?: $this->getKernel()->getProjectDir(). DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml';
    }
}