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
 * Date: 16/12/2018
 * Time: 08:20
 */
namespace App\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

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
     * execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $kernel = $this->getApplication()->getKernel();
        $fileSystem = new Filesystem();
        if (isset($_SERVER['APP_TRAVIS_TEST']))
        {

            $application = new Application($kernel);
            $application->setAutoExit(false);

            $input = new ArrayInput(
                [
                    'command' => 'doctrine:database:create',
                    // (optional) define the value of command arguments
                    '--env' => 'test',
                ]
            );

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $result = $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            if ($result !== 0)
                return 45;


            $input = new ArrayInput(
                [
                    'command' => 'doctrine:schema:create',
                    // (optional) define the value of command arguments
                    '--env' => 'test',
                ]
            );

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $result = $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            if ($result !== 0)
                return 46;


            $file = $kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml';
            if (!$fileSystem->exists($file)) {
                $fileSystem->copy($kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml' . '.dist', $kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml', false);
            }
            $file = realpath($kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml');

            $content = Yaml::parse(file_get_contents($file));
            $content['parameters']['db_host'] = '127.0.0.1';
            $content['parameters']['db_name'] = 'mobile_test';
            $content['parameters']['db_user'] = 'root';
            $content['parameters']['db_pass'] = null;
            $content['parameters']['gibbon_document_root'] = '../../';

            $fileSystem->dumpFile($file, Yaml::dump($content, 8));
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
                        if ($fileSystem->exists($config))
                            break;
                    }
                }
        }

        $config = rtrim($gibbonRoot, '\\/') . DIRECTORY_SEPARATOR . 'config.php';
        if (! $fileSystem->exists($config)) {
            $io->error(sprintf('The Gibbon config.php file was not found at "%s".  You may need to run the gibbon installation scripts manually as the automatic search for your Gibbon installation appears to have failed.  I searched "%s" directory for the Gibbon installation.  See "http://www.craigrayner.com/help/installation.php"', $config, $projectDir['dirname']));
            return 1;
        } else {
            $io->success(sprintf('The Gibbon config.php file was found at "%s"', $config));

            include $config;

            // now build .env.local file

            $file = $kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml';
            if (!$fileSystem->exists($file)) {
                $fileSystem->copy($kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml' . '.dist', $kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml', false);
            }
            $file = realpath($kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml');

            $content = Yaml::parse(file_get_contents($file));
            $content['parameters']['db_host'] = $databaseServer;
            $content['parameters']['db_name'] = $databaseName;
            $content['parameters']['db_user'] = $databaseUsername;
            $content['parameters']['db_pass'] = $databasePassword;
            $content['parameters']['gibbon_document_root'] = $gibbonRoot;

            $fileSystem->dumpFile($file, Yaml::dump($content, 8));
            $io->success('Database settings have been transferred from Gibbon to the Gibbon-Mobile framework.');
        }

        //Create .htaccess File in public
        $file = $kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . '.htaccess' ;
        if (! $fileSystem->exists($file))
            $fileSystem->copy($file . '.dist', $file);

        $realCacheDir = $kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . '*';
        $fileSystem->remove($realCacheDir);

        return 0;
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
}