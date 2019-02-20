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
 * Time: 18:49
 */
namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class GibbonInstallation extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'gibbon:install';

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
        if (file_exists($kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon_mobile.yaml'))
            return 0;

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(
            [
                'command' => 'gibbon:environment:install',
            ]
        );

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $result = $application->run($input, $output);

        // return the output, don't use if you used NullOutput()
        if ($result !== 0)
            return $result;

/*        $input = new ArrayInput(
            [
                'command' => 'cache:clear',
            ]
        );

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $result = $application->run($input, $output);
        echo $output->fetch();

        // return the output, don't use if you used NullOutput()
        if ($result !== 0)
            return $result;
*/

        $input = new ArrayInput(
            [
                'command' => 'gibbon:setting:install',
            ]
        );

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $result = $application->run($input, $output);

        // return the output, don't use if you used NullOutput()
        if ($result !== 0)
            return $result;


        $input = new ArrayInput(
            [
                'command' => 'gibbon:translation:install',
            ]
        );

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $result = $application->run($input, $output);

        // return the output, don't use if you used NullOutput()
        if ($result !== 0)
            return $result;


        $input = new ArrayInput(
            [
                'command' => 'assets:install --symlink --relative',
//                'public' => 'public',
//                'symlink' => '--symlink',
//                'relative' => '--relative'
            ]
        );

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $result = $application->run($input, $output);


        // return the output, don't use if you used NullOutput()
        if ($result !== 0)
            return $result;

        return 0;
    }
}