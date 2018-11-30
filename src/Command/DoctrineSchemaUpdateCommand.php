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

use App\Entity\Module;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class DoctrineSchemaUpdateCommand
 * @package App\Command
 */
class DoctrineSchemaUpdateCommand extends Command
{
    protected static $defaultName = 'gibbon:schema:update';

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * DoctrineSchemaUpdateCommand constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct();

        $this->manager = $manager;
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
        $entityName = 'App\Entity\\' . $input->getArgument('entityName');
        $schemaTool = new SchemaTool($this->manager);
        $metadata = $this->manager->getClassMetadata($entityName);
        $sqlDiff = $schemaTool->getUpdateSchemaSql([$metadata], true);

        $io = new SymfonyStyle($input, $output);
        $io->newLine();

        $io->text('Checking entity <info>'.$entityName.'</info>.');
        $io->newLine();
        $success = true;
        foreach($sqlDiff as $s) {
            $io->text($s);
            if (mb_strpos($s, "ADD") !== false)
            {
                $io->warning('The system is adding an new field.');
                $io->newLine();
                $success = false;
            }
            if (mb_strpos($s, "DROP") !== false)
            {
                $io->warning('The system is dropping a field or index.');
                $io->newLine();
                $success = false;
            }
            if (mb_strpos($s, "RENAME INDEX") !== false)
            {
                $io->warning('The system is changing an index.');
                $io->newLine();
                $success = false;
            }
            $io->newLine();
        }

        if ($input->getOption('force') && $success)
        {
            $io->note('Write the changes to the database will be attempted.');
            $io->newLine();
            $schemaTool->updateSchema([$metadata], true);
        }

        if ($success)
            $io->success(sprintf('Looks like "%s" is ready to go.', $entityName));

        return $exitCode = 0;
    }

    /**
     * configure
     *
     */
    protected function configure()
    {
        $this
            // ...
            ->addArgument('entityName', InputArgument::REQUIRED, 'Which entity do you wish to check for update?')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Write the changes to the database on successful validation.')

        ;
    }
}
