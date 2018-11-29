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
 * UserProvider: craig
 * Date: 24/11/2018
 * Time: 09:22
 */
namespace App\Command;

use App\Entity\Setting;
use App\Manager\SettingManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Exception\IOException;
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

    protected static $defaultName = 'translation:install';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var string
     */
    private $gibbonDocumentRoot;

    /**
     * @var SettingManager
     */
    private $manager;

    /**
     * InstallCommand constructor.
     * @param Finder $finder
     * @param string $gibbonDocumentRoot
     */
    public function __construct(string $gibbonDocumentRoot, SettingManager $manager)
    {
        parent::__construct();

        $this->finder = new Finder();
        $this->gibbonDocumentRoot = $gibbonDocumentRoot;
        $this->filesystem = new Filesystem();
        $this->finder->exclude(['LC_MESSAGES']);
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

        $sourceDir = realpath($this->gibbonDocumentRoot);

        if (!is_dir($sourceDir)) {
            throw new \InvalidArgumentException(sprintf('The source directory "%s" does not exist. Set the "gibbon_document_root" parameter in the "gibbon_mobile.yaml_x"' , $this->gibbonDocumentRoot));
        }
        $sourceDir = rtrim($sourceDir, "\\/") . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR;
        if (!is_dir($sourceDir)) {
            throw new \InvalidArgumentException(sprintf('The source directory "%s" does not exist.', $sourceDir));
        }

        $this->finder->directories()->in($sourceDir);

        $targetDir = $kernel->getContainer()->getParameter('kernel.project_dir') . DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR;

        $io = new SymfonyStyle($input, $output);
        $io->newLine();

        if ($input->getOption('relative')) {
            $expectedMethod = self::METHOD_RELATIVE_SYMLINK;
            $io->text('Trying to install translations as <info>relative symbolic links</info>.');
        } elseif ($input->getOption('symlink')) {
            $expectedMethod = self::METHOD_ABSOLUTE_SYMLINK;
            $io->text('Trying to install translations as <info>absolute symbolic links</info>.');
        } else {
            $expectedMethod = self::METHOD_COPY;
            $io->text('Installing translations as <info>hard copies</info>.');
        }

        $io->newLine();

        $rows = array();
        $copyUsed = false;
        $exitCode = 0;

        $targetDir = $kernel->getContainer()->getParameter('kernel.project_dir'). DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR;

        if (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
            $message = sprintf("%s\n-> %s", 'Translation Transfer', $targetDir);
        } else {
            $message = 'Translation Transfer';
        }

        $this->filesystem->mkdir(\dirname($targetDir), 0755);

        $method = $expectedMethod;

        foreach($this->finder as $dir) {

            $locale = $dir->getBasename();
            $source = $dir->getPathname() . DIRECTORY_SEPARATOR . 'LC_MESSAGES' . DIRECTORY_SEPARATOR ;

            if (! file_exists($source)) {
                $rows[] = array(sprintf('<fg=yellow;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'WARNING' : '!'), $message, $locale);
            } else {
                $finder = new Finder();

                $finder->name("/(\.mo$)|(\.po$)/")->in($source);

                foreach($finder as $file) {
                    $source = $file->getPathname();
                    $target = $targetDir . 'messages.' . $locale . '.' . $file->getExtension();

                    try {
                        if ($method === self::METHOD_RELATIVE_SYMLINK)
                            $method = $this->relativeSymlinkWithFallback($source,$target);
                        elseif ($method === self::METHOD_ABSOLUTE_SYMLINK)
                            $method = $this->relativeSymlinkWithFallback($source,$target);
                        else
                            $method = $this->hardCopy($source, $target);

                        if (self::METHOD_COPY === $method) {
                            $copyUsed = true;
                        }

                        if ($method === $expectedMethod) {
                            $rows[] = array(sprintf('<fg=green;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'OK' : "\xE2\x9C\x94" /* HEAVY CHECK MARK (U+2714) */), $message . ' for ' . $locale, $method);
                        } else {
                            $rows[] = array(sprintf('<fg=yellow;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'WARNING' : '!'), $message . ' for ' . $locale, $method);
                        }
                    } catch (\Exception $e) {
                        $exitCode = 1;
                        $rows[] = array(sprintf('<fg=red;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'ERROR' : "\xE2\x9C\x98" /* HEAVY BALLOT X (U+2718) */), $message . ' for ' . $locale, $e->getMessage());
                    }

                    if ($locale === 'en_GB') {
                        $locale = 'en';
                        $target = $targetDir . 'messages.en.' . $file->getExtension();

                        try {
                            if ($method === self::METHOD_RELATIVE_SYMLINK)
                                $method = $this->relativeSymlinkWithFallback($source, $target);
                            elseif ($method === self::METHOD_ABSOLUTE_SYMLINK)
                                $method = $this->relativeSymlinkWithFallback($source, $target);
                            else
                                $method = $this->hardCopy($source, $target);

                            if (self::METHOD_COPY === $method) {
                                $copyUsed = true;
                            }

                            if ($method === $expectedMethod) {
                                $rows[] = array(sprintf('<fg=green;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'OK' : "\xE2\x9C\x94" /* HEAVY CHECK MARK (U+2714) */), $message . ' for ' . $locale, $method);
                            } else {
                                $rows[] = array(sprintf('<fg=yellow;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'WARNING' : '!'), $message . ' for ' . $locale, $method);
                            }
                        } catch (\Exception $e) {
                            $exitCode = 1;
                            $rows[] = array(sprintf('<fg=red;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'ERROR' : "\xE2\x9C\x98" /* HEAVY BALLOT X (U+2718) */), $message . ' for ' . $locale, $e->getMessage());
                        }
                    }
                }

            }
        }

        if ($rows) {
            $io->table(array('', '', 'Method / Error'), $rows);
        }

        if (0 !== $exitCode) {
            $io->error('Some errors occurred while installing translations.');
        } else {
            if ($copyUsed) {
                $io->note('Some translations were installed via copy. If you make changes to these translations in Gibbon you have to run this command again.');
            }
            $io->success($rows ? 'All translations were successfully installed.' : 'No translations were provided by Gibbon.');
            $setting = $this->getSettingManager()->getSettingByScope('Mobile', 'translationTransferDate', true);
            if (empty($setting)) {
                $setting = new Setting();
                $setting->setNameDisplay('Last Translation Transfer Date');
                $setting->setScope('Mobile');
                $setting->setName('translationTransferDate');
                $setting->setDescription('This setting keeps track of the last date the translations were built from the Gibbon source.');
            }
            $setting->setValue(serialize(new \DateTime('now')));
            $this->getSettingManager()->createSetting($setting);
        }

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
The <info>%command.name%</info> command installs translation files from the <comment>i18n</comment> directory in Gibbon to the <comment>translations</comment> directory in the <comment>Gibbon-Mobile</comment> application.

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

    /**
     * relativeSymlinkWithFallback
     *
     * @param string $origin
     * @param string $target
     * @return string
     */
    private function relativeSymlinkWithFallback(string $origin, string $target): string
    {
        try {
            $this->symlink($origin, $target, true);
            $method = self::METHOD_RELATIVE_SYMLINK;
        } catch (IOException $e) {
            $method = $this->absoluteSymlinkWithFallback($origin, $target);
        }

        return $method;
    }

    /**
     * absoluteSymlinkWithFallback
     *
     * @param string $origin
     * @param string $target
     * @return string
     */
    private function absoluteSymlinkWithFallback(string $origin, string $target): string
    {
        try {
            $this->symlink($origin, $target, false);
            $method = self::METHOD_ABSOLUTE_SYMLINK;
        } catch (IOException $e) {
            // fall back to copy
            $method = $this->hardCopy($origin, $target);
        }

        return $method;
    }

    /**
     * symlink
     *
     * @param string $origin
     * @param string $target
     * @param bool $relative
     */
    private function symlink(string $origin, string $target, bool $relative = false)
    {
        if ($relative) {
            $this->filesystem->copy($origin, $target, true);
            $origin = $this->filesystem->makePathRelative($origin, realpath($target));
        }
        $this->filesystem->symlink($origin, $target);
        if (!file_exists($target)) {
            throw new IOException(sprintf('Symbolic link "%s" was created but appears to be broken.', $target), 0, null, $target);
        }
    }

    /**
     * hardCopy
     *
     * @param string $origin
     * @param string $target
     * @return string
     */
    private function hardCopy(string $origin, string $target): string
    {
        $this->filesystem->copy($origin, $target, true);

        return self::METHOD_COPY;
    }
}