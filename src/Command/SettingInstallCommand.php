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
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Command;

use App\Entity\I18n;
use App\Manager\InstallationManager;
use App\Provider\SettingProvider;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SettingInstallCommand
 * @package App\Command
 */
class SettingInstallCommand extends Command
{
    protected static $defaultName = 'gibbon:setting:install';

    /**
     * @var SettingProvider
     */
    private $manager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var InstallationManager
     */
    private $installationManager;

    /**
     * SettingInstallCommand constructor.
     * @param SettingProvider $manager
     */
    public function __construct(SettingProvider $manager, InstallationManager $installationManager)
    {
        parent::__construct();

        $this->manager = $manager;
        $this->logger = $manager->getContainer()->get('monolog.logger.setting');
        $this->installationManager = $installationManager;
        $this->installationManager->setLogger($this->logger)
            ->setSettingManager($this->getSettingManager());
    }

    /**
     * @return SettingProvider
     */
    public function getSettingManager(): SettingProvider
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
        $this->getSettingManager()->clearSettingCache();
        $this->installationManager->setKernel($this->getApplication()->getKernel());

        $exitCode = $this->installationManager->settings();

        $io = new SymfonyStyle($input, $output);
        $io->newLine();

        foreach($this->installationManager->getMessageManager()->getMessages() as $message)
        {
            $method = $message->getLevel();
            $io->$method($message->getMessage());
        }

        $this->installationManager->getMessageManager()->clearMessages();

        return $exitCode;
    }
}
