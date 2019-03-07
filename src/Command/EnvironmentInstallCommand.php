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
 * Date: 16/12/2018
 * Time: 08:20
 */
namespace App\Command;

use App\Manager\InstallationManager;
use App\Util\VersionHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class EnvironmentInstallCommand
 * @package App\Command
 */
class EnvironmentInstallCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'gibbon:environment:install';

    /**
     * @var InstallationManager
     */
    private $installationManager;

    /**
     * EnvironmentInstallCommand constructor.
     * @param InstallationManager $installationManager
     */
    public function __construct(InstallationManager $installationManager)
    {
        parent::__construct();
        $this->installationManager = $installationManager;    
    }

    /**
     * getInstallationManager
     * @return InstallationManager
     */
    public function getInstallationManager(): InstallationManager
    {
        return $this->installationManager;
    }

    /**
     * execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $kernel = $this->getApplication()->getKernel();
        $this->getInstallationManager()->setKernel($kernel);
        return $this->executeCommand($input, $output, $kernel);
    }

    /**
     * configure
     *
     */
    protected function configure()
    {
        $this
            // ...
            ->addArgument('gibbonRoot', InputArgument::OPTIONAL, 'Define the Gibbon installation Root Directory?')

        ;
    }

    public function executeCommand(InputInterface $input, OutputInterface $output, KernelInterface $kernel): int
    {
        $fileSystem = new Filesystem();
        if (isset($_SERVER['APP_TRAVIS_TEST']))
        {

            $file = $this->getInstallationManager()->getFile();
            if (! $fileSystem->exists($file))
                $fileSystem->copy($file . '.travis', $file, false);

            $content = $this->getInstallationManager()->getMobileParameters();
            $content['db_host'] = '127.0.0.1';
            $content['db_name'] = 'mobile_test';
            $content['db_name'] = 'mobile_test';
            $content['db_user'] = 'root';
            $content['db_pass'] = null;
            $content['gibbon_document_root'] = realpath(__DIR__.'/../../Gibbon');

            $this->getInstallationManager()->setMobileParameters($content);
            return 0;
        }

        $io = new SymfonyStyle($input, $output);
        $io->newLine();

        $projectDir = pathinfo($kernel->getProjectDir());

        $gibbonRoot = $input->getArgument('gibbonRoot');
        if (empty($gibbonRoot) || ! $fileSystem->exists($gibbonRoot)) {
            $finder = new Finder();
            $finder->in($projectDir['dirname']);
            $finder->depth('<=1');
            foreach ($finder as $file)
                if ($file->isFile() && $file->getFilename() === 'composer.json') {
                    $content = json_decode(file_get_contents($file->getPathname()));
                    if (property_exists($content, 'name') && $content->name === 'gibbonedu/core') {
                        $gibbonRoot = $file->getPath();
                        $config = rtrim($gibbonRoot, '\\/') . DIRECTORY_SEPARATOR . 'config.php';
                        $gibbonVersionFile = trim($gibbonRoot, '\\/') . DIRECTORY_SEPARATOR . 'version.php';
                        $version = '';
                        if (file_exists($gibbonVersionFile))
                            include $gibbonVersionFile;
                        if ($fileSystem->exists($config)){
                            $valid = false;
                            foreach(VersionHelper::GIBBON as $gVersion)
                            {
                                if (version_compare($gVersion, $version, '='))
                                {
                                    $valid = true;
                                    break;
                                }
                            }
                            if ($valid)
                                break;
                        }
                    }
                }
        }

        $config = rtrim($gibbonRoot, '\\/') . DIRECTORY_SEPARATOR . 'config.php';
        if (! $fileSystem->exists($config)) {
            $io->error(sprintf('The Gibbon config.php file was not found at "%s".  You may need to run the gibbon installation scripts manually as the automatic search for your Gibbon installation appears to have failed.  I searched "%s" sub directories for the Gibbon installation matching version [%s].  See "http://gibhelp.craigrayner.com" for further help.', $config, $projectDir['dirname'], implode(',',VersionHelper::GIBBON)));
            return 1;
        } else {
            $io->success(sprintf('The Gibbon config.php file was found at "%s" for Gibbon version [%s]', $config, implode(',', VersionHelper::GIBBON)));

            include $config;

            $file = $this->getInstallationManager()->getFile();
            if (!$fileSystem->exists($file))
                $fileSystem->copy($file . '.dist', $file, false);

            $content = $this->getInstallationManager()->getMobileParameters();
            $content['db_host'] = $databaseServer;
            $content['db_name'] = $databaseName;
            $content['db_user'] = $databaseUsername;
            $content['db_pass'] = $databasePassword;
            $content['gibbon_document_root'] = $gibbonRoot;

            $this->getInstallationManager()->setMobileParameters($content);
            $io->success('Database settings have been transferred from Gibbon to the Gibbon-Responsive framework.');
        }

        //Create .htaccess File in public
        $file = $kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . '.htaccess' ;
        if (! $fileSystem->exists($file))
            $fileSystem->copy($file . '.dist', $file);

        $realCacheDir = $kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . '*';
        $fileSystem->remove($realCacheDir);

        return 0;
    }
}