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
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SettingInstallCommand
 * @package App\Command
 */
class SettingInstallCommand extends Command
{
    protected static $defaultName = 'setting:install';

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

        $exitCode = 0;
        $io = new SymfonyStyle($input, $output);
        $io->newLine();

        $file = realpath($kernel->getProjectDir(). DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . 'gibbon.yaml');

        $fileSystem = new Filesystem();
        if (! $fileSystem->exists($file))
            $fileSystem->dumpFile($file, '');
        $content = file_get_contents($file);
        $gibbon = Yaml::parse($content);

        $gibbon['parameters']['cookie_lifetime'] = $this->getSettingManager()->getSettingByScopeAsInteger('System', 'sessionDuration', 1200);

        $content = Yaml::dump($gibbon, 8);

        $fileSystem->dumpFile($file, $content);
        $io->success('Critical settings have been set into the Gibbon-Mobile framework.');

        return $exitCode;
    }

}