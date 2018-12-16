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

use App\Manager\SettingManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
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

        $file = $kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml';

        $fileSystem = new Filesystem();
        if (! $fileSystem->exists($file))
            $fileSystem->copy($file.'.dist', $file, false);

        $gibbonRoot = $this->getSettingManager()->getSettingByScopeAsString('System', 'absolutePath');

        $config = rtrim($gibbonRoot, '\\/') . DIRECTORY_SEPARATOR . 'config.php';
        if (! $fileSystem->exists($config)) {
            $io->error(sprintf('The Gibbon config.php file was not found at "%s"', $config));
            return 1;
        } else {
            $io->success(sprintf('The Gibbon config.php file was found at "%s"', $config));
            // now build .env file for the mailer
            if ($this->getSettingManager()->getSettingByScopeAsString('System', 'enableMailerSMTP', 'N') === 'Y') {

                $file = realpath($kernel->getProjectDir() . DIRECTORY_SEPARATOR . '.env');

                $env = file($file);

                foreach ($env as $q => $line) {
                    if (strpos($line, 'MAILER_URL=') === false)
                        continue;

                    //MAILER_URL=smtp://localhost:25?encryption=ssl&auth_mode=login&username=&password=
                    $host = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPHost', null);
                    $port = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPPort', null);
                    $encryption = 'none';
                    if ($port === '465')
                        $encryption = 'ssl';
                    if ($port === '587')
                        $encryption = 'tls';
                    $username = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPUsername', null);
                    $password = $this->getSettingManager()->getSettingByScopeAsString('System', 'mailerSMTPPassword', null);

                    $env[$q] = 'MAILER_URL=smtp://'.$host.':'.$port.'?encryption='.$encryption.'&auth_mode=login&username='.$username.'&password='.$password."\n";
                }

                $content = implode('', $env);

                $fileSystem->dumpFile($file, $content);
                $io->success('Environmental settings have been set into the Gibbon-Mobile framework.');
            }else {
                $file = realpath($kernel->getProjectDir() . DIRECTORY_SEPARATOR . '.env');

                $env = file($file);

                foreach ($env as $q => $line) {
                    if (strpos($line, 'MAILER_URL=') === false)
                        continue;
                    $env[$q] = "MAILER_URL=null://localhost\n";
                }

                $content = implode('', $env);

                $fileSystem->dumpFile($file, $content);
                $io->success('Environmental settings have been set into the Gibbon-Mobile framework.');
            }

            $file = realpath($kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml');

            $content = file_get_contents($file);
            $gibbon = Yaml::parse($content);

            $gibbon['parameters']['cookie_lifetime'] = $this->getSettingManager()->getSettingByScopeAsInteger('System', 'sessionDuration', 1200);
            $gibbon['parameters']['google_client_id'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'googleClientID', '');
            $gibbon['parameters']['google_secret'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'googleClientSecret', '');
            $gibbon['parameters']['timezone'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'timezone', 'UTC');
            $gibbon['parameters']['gibbon_document_root'] = $gibbonRoot;
            $gibbon['parameters']['gibbon_host_url'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'absoluteURL').'/';
            $gibbon['parameters']['mailer_sender_address'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'organisationEmail', null);
            $gibbon['parameters']['mailer_sender_name'] = $this->getSettingManager()->getSettingByScopeAsString('System', 'organisationName', null);

            if ($this->getSettingManager()->getSettingByScopeAsString('System', 'enableMailerSMTP', 'N') === 'Y') {
                $gibbon['parameters']['mailer_transport'] = 'smtp';
                $gibbon['parameters']['mailer_host'] = $host;
                $gibbon['parameters']['mailer_port'] = $port;
                $gibbon['parameters']['mailer_user'] = $username;
                $gibbon['parameters']['mailer_password'] = $password;
                $gibbon['parameters']['mailer_encryption'] = $encryption;
                $gibbon['parameters']['mailer_auth_mode'] = 'login';
            } else {

                $gibbon['parameters']['mailer_transport'] = null;
                $gibbon['parameters']['mailer_host'] = null;
                $gibbon['parameters']['mailer_port'] = '25';
                $gibbon['parameters']['mailer_user'] = null;
                $gibbon['parameters']['mailer_password'] = 'null';
                $gibbon['parameters']['mailer_encryption'] = 'none';
                $gibbon['parameters']['mailer_auth_mode'] = 'plain';
            }

            $content = Yaml::dump($gibbon, 8);

            $fileSystem->dumpFile($file, $content);
            $io->success('Critical settings have been set into the Gibbon-Mobile framework.');
        }

        $file = $kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build' ;

        $fileSystem->remove($file);

        $fileSystem->mirror($kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'dist', $file);

        return 0;
    }
}
