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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kernel = $this->getApplication()->getKernel();

        $io = new SymfonyStyle($input, $output);
        $io->newLine();

        $fileSystem = new Filesystem();
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

            $fileSystem->dumpFile($file, Yaml::dump($content, 8));
            $io->success('Database settings have been transferred from Gibbon to the Gibbon-Mobile framework.');
        }

        //Create .htaccess File in public
        $file = $kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . '.htaccess' ;
        if (! $fileSystem->exists($file))
            $fileSystem->copy($file . '.dist', $file);

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