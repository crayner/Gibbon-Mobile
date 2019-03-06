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
 * UserProvider: craig
 * Date: 24/11/2018
 * Time: 09:22
 */
namespace App\Command;

use App\Manager\InstallationManager;
use App\Manager\SettingManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class InstallCommand
 * @package App\Command
 */
class TranslationInstallCommand extends Command
{
    const METHOD_COPY = 'copy';
    const METHOD_ABSOLUTE_SYMLINK = 'absolute symlink';
    const METHOD_RELATIVE_SYMLINK = 'relative symlink';

    protected static $defaultName = 'gibbon:translation:install';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var SettingManager
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
     * InstallCommand constructor.
     * @param Finder $finder
     * @param string $gibbonDocumentRoot
     */
    public function __construct(SettingManager $manager)
    {
        parent::__construct();

        $this->finder = new Finder();
        $this->manager = $manager;
        $this->filesystem = new Filesystem();
        $this->finder->exclude(['LC_MESSAGES']);
        $this->logger = $manager->getContainer()->get('monolog.logger.setting');
        $this->installationManager = new InstallationManager();
        $this->installationManager->setSettingManager($manager)
            ->setKernel($manager->getContainer()->get('kernel'))
            ->setLogger($this->logger);
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
        if (isset($_SERVER['APP_TRAVIS_TEST']))
            return 0;
        $this->installationManager->setKernel($this->getApplication()->getKernel());

        $exitCode = $this->installationManager->translations();

        $io = new SymfonyStyle($input, $output);
        $io->newLine();

        foreach($this->installationManager->getMessageManager()->getMessages() as $message)
        {
            $method = $message->getLevel();
            switch ($method)
            {
                case 'info':
                    $method = 'note';
                    break;
                case 'warning':
                    $method = 'note';
                    break;
            }
            $io->$method($message->getMessage());
        }

        $this->installationManager->getMessageManager()->clearMessages();

        return $exitCode;
    }

    /**
     * configure
     *
     */
    protected function configure()
    {
        $this
            ->addOption('symlink', null, InputOption::VALUE_NONE, 'Symlinks the assets instead of copying it')
            ->addOption('relative', null, InputOption::VALUE_NONE, 'Make relative symlinks')
            ->setDescription('Copies the translations from Gibbon, and converts for use by the mobile application.')
            ->setHelp(<<<'EOT'
The <info>%command.name%</info> command installs translation files from the <comment>i18n</comment> directory in Gibbon to the <comment>translations</comment> directory in the <comment>Gibbon-Responsive</comment> application.

  <info>php %command.full_name%</info>

A "translation" directory will be created inside the project directory and the
Gibbon translations will be copied into it.

To create a symlink to each bundle instead of copying its assets, use the
<info>--symlink</info> option (will fall back to hard copies when symbolic links aren't possible:

  <info>php %command.full_name% --symlink</info>

To make symlink relative, add the <info>--relative</info> option:

  <info>php %command.full_name% public --symlink --relative</info>

EOT
            )
        ;
    }
}