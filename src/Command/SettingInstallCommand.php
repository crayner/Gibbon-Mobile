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
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Command;

use App\Entity\I18n;
use App\Manager\SettingManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SettingInstallCommand
 * @package App\Command
 */
class SettingInstallCommand extends Command
{
    protected static $defaultName = 'gibbon:setting:install';

    /**
     * @var SettingManager
     */
    private $manager;

    /**
     * SettingInstallCommand constructor.
     * @param SettingManager $manager
     */
    public function __construct(SettingManager $manager)
    {
        parent::__construct();

        $this->manager = $manager;
    }

    /**
     * @return SettingManager
     */
    public function getSettingManager(): SettingManager
    {
        return $this->manager;
    }

    /**
     * execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kernel = $this->getApplication()->getKernel();

        $io = new SymfonyStyle($input, $output);
        $io->newLine();

        $file = realpath($kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml');
        $io->success(sprintf('File: %s', $file));

        $content = Yaml::parse(file_get_contents($file));
        $gibbonRoot = $content['parameters']['gibbon_document_root'];
        $io->success(sprintf('Gibbon Document Root: %s', $gibbonRoot));

        $fileSystem = new Filesystem();
        if (! $fileSystem->exists($file))
            $fileSystem->copy($file.'.dist', $file, false);

        $config = rtrim($gibbonRoot, '\\/') . DIRECTORY_SEPARATOR . 'config.php';
        if (! $fileSystem->exists($config)) {
            $io->error(sprintf('The Gibbon config.php file was not found at "%s"', $config));
            return 1;
        } else {
            $io->success(sprintf('The Gibbon config.php file was found at "%s"', $config));
            // now build .env.local file for the mailer
            if ($this->getSettingManager()->getSettingByScopeAsBoolean('System', 'enableMailerSMTP', 'N')) {

                if ($gibbonRoot !== $content['parameters']['gibbon_document_root'])
                {
                    $io->error(sprintf('The database absolute path %s does not equal the config path %s', $gibbonRoot, $content['parameters']['gibbon_document_root']));
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


                $fileSystem->dumpFile($file, Yaml::dump($content,8));
                $io->success('Email settings have been copied from the Gibbon Setup');
            }else {
                $file = realpath($kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml');


                $content = Yaml::parse(file_get_contents($file));

                $content['parameters']['mailer_host'] = null;
                $content['parameters']['mailer_transport'] = null;
                $content['parameters']['mailer_auth_mode'] = null;
                $content['parameters']['mailer_transport'] = null;
                $content['parameters']['mailer_port'] = null;
                $content['parameters']['mailer_encryption'] = null;
                $content['parameters']['mailer_user'] = null;
                $content['parameters']['mailer_password'] = null;
                $content['parameters']['mailer_spool'] = ['type' => 'memory'];


                $fileSystem->dumpFile($file, Yaml::dump($content,8));
                $io->success('Email settings have been set as default and turned off.');
            }

            $file = realpath($kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml');

            $content = file_get_contents($file);
            $gibbon = Yaml::parse($content);

            $gibbon['parameters']['cookie_lifetime'] = $this->getSettingManager()->getSettingByScopeAsInteger('System', 'sessionDuration', 1200);
            $gibbon['parameters']['google_client_id'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'googleClientID', '');
            $gibbon['parameters']['google_secret'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'googleClientSecret', '');
            $gibbon['parameters']['timezone'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'timezone', 'UTC');
            $gibbon['parameters']['gibbon_document_root'] = $gibbonRoot;
            $gibbon['parameters']['gibbon_host_url'] = ($this->getSettingManager()->getSettingByScopeAsString('System', 'absoluteURL') ?: '').'/';
            $gibbon['parameters']['mailer_sender_address'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'organisationEmail', null);
            $gibbon['parameters']['mailer_sender_name'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'organisationName', null);
            $gibbon['parameters']['locale'] = $this->getSettingManager()->getRepository(I18n::class)->createQueryBuilder('i')
                ->where('i.systemDefault = :yes')
                ->setParameter('yes', 'Y')
                ->select('i.code')
                ->getQuery()
                ->getSingleScalarResult() ?: 'en_GB';

            $content = Yaml::dump($gibbon, 8);

            $fileSystem->dumpFile($file, $content);
            $io->success('Environmental settings have been set into the Gibbon-Mobile framework.');
        }

        $file = $kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build' ;

        $fileSystem->remove($file);

        $fileSystem->mirror($kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'dist', $file);

        $io->success('Assets have been copied from dist to build directory!');


        return 0;
    }
}
