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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

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

        $helper = $this->getHelper('question');
        $question = new Question('What is the Gibbon Document Root (absolute) (Default: '.$projectDir['dirname'] . DIRECTORY_SEPARATOR . 'core)'.'? ', $projectDir['dirname'] . DIRECTORY_SEPARATOR . 'core');

        $gibbonRoot = $helper->ask($input, $output, $question);

        $config = rtrim($gibbonRoot, '\\/') . DIRECTORY_SEPARATOR . 'config.php';
        if (! $fileSystem->exists($config)) {
            $io->error(sprintf('The Gibbon config.php file was not found at "%s"', $config));
            return 1;
        } else {
            $io->success(sprintf('The Gibbon config.php file was found at "%s"', $config));

            include $config;
            // now build .env file

            $file = realpath($kernel->getProjectDir(). DIRECTORY_SEPARATOR . '.env');
            if (!$fileSystem->exists($file))
                $fileSystem->copy($file.'.dist', $file, false);


            $env = file($file);

            foreach($env as $q=>$line) {
                if (strpos($line, 'DATABASE_URL=mysql://') === false)
                    continue;

                $env[$q] = 'DATABASE_URL=mysql://'.$databaseUsername.':'.$databasePassword.'@'.$databaseServer.':3306/'.$databaseName."\n";
            }
            $content = implode('', $env);

            $fileSystem->dumpFile($file, $content);
            $io->success('Environmental settings have been set into the Gibbon-Mobile framework.');
        }
        return 0;
    }
}