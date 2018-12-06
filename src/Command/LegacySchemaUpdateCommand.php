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

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LegacySchemaUpdateCommand
 * @package App\Command
 */
class LegacySchemaUpdateCommand extends Command
{
    protected static $defaultName = 'legacy:schema:update';

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
                $io->warning('The system is adding a field or index.');
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

        if ($input->getOption('columns') && $success)
        {
            $columns = $this->manager->getConnection()->fetchAll('SHOW FULL COLUMNS FROM ' . $metadata->table['name']);
            foreach($columns as $field)
            {
                $targetName = $metadata->getFieldName($field['Field']);
                try {
                    $assoc = false;
                    $new = $metadata->getFieldMapping($metadata->getFieldName($field['Field']));
                } catch (MappingException $e) {
                    $assocMap = $this->loadFromAssociatedMappings($metadata, $targetName);
                    $new = reset($assocMap['joinColumns']);
                    $assoc = true;
                }

                $new['options'] = isset($new['options']) ? $new['options'] : [];
                $new['columnDefinition'] = isset($new['columnDefinition']) ? strtolower($new['columnDefinition']) : '';

                $resolver = new OptionsResolver();
                $resolver->setDefaults(
                    [
                        'comment' => '',
                        'default' => null,
                    ]
                );
                $new['options'] = $resolver->resolve($new['options']);

                if ($assoc){
                    if (($field['Null'] === 'NO' && $new['nullable']) || ($field['Null'] === 'YES' && ! $new['nullable']))
                    {
                        $io->warning(sprintf('The field "%s" is changing the NULL value to "%s"', $targetName, $new['nullable'] ? 'true' : 'false'));
                        $io->newLine();
                        $success = false;
                    }

                    $targetEntity =  $this->manager->getClassMetadata($assocMap['targetEntity']);
                    $new = $targetEntity->getFieldMapping($targetEntity->getFieldName($new['referencedColumnName']));
                    switch ($new['type']) {
                        case 'bigint':
                        case 'smallint':
                        case 'integer':
                            if ($field['Type'] === strtolower($new['columnDefinition']))
                                break;

                            $new['columnDefinition'] = strtolower($new['columnDefinition']);
                            $new_zerofill = strpos($new['columnDefinition'], 'zerofill') === false ? false : true;
                            $exist_zerofill = strpos($field['Type'], 'zerofill') === false ? false : true;
                            if ($new_zerofill !== $exist_zerofill){
                                $io->warning(sprintf('The field "%s" is changing the ZEROFILL value to "%s"', $targetName, $new_zerofill ? 'true' : 'false'));
                                $io->newLine();
                                $success = false;
                                break;
                            }

                            $new_zerofill = strpos($new['columnDefinition'], 'unsigned') === false ? false : true;
                            $exist_zerofill = strpos($field['Type'], 'unsigned') === false ? false : true;
                            if ($new_zerofill !== $exist_zerofill){
                                $io->warning(sprintf('The field "%s" is changing the UNSIGNED value to "%s"', $targetName, $new_zerofill ? 'true' : 'false'));
                                $io->newLine();
                                $success = false;
                                break;
                            }

                            $new = intval(str_replace([' ','zerofill', 'unsigned', 'int(', ')'], '', $new['columnDefinition']));
                            $exist = intval(str_replace([' ','zerofill', 'unsigned', 'int(', ')'], '', $field['Type']));
                            if ($new !== $exist){
                                $io->warning(sprintf('The field "%s" is changing the INTEGER LENGTH value from "%s" to "%s"', $targetName, $exist, $new));
                                $io->newLine();
                                $success = false;
                                break;
                            }


                            dd(__LINE__,$field,$new);
                            break;
                        default:
                            dd(__LINE__,$field,$new);
                    }
                } else {
                    if (($field['Null'] === 'NO' && $new['nullable']) || ($field['Null'] === 'YES' && ! $new['nullable']))
                    {
                        $io->warning(sprintf('The field "%s" is changing the NULL value to "%s"', $targetName, $new['nullable'] ? 'true' : 'false'));
                        $io->newLine();
                        $success = false;
                    }

                    $comment = $new['options']['comment'];
                    if ($field['Comment'] !== $comment)
                    {
                        $io->warning(sprintf('The field "%s" is changing the COMMENT value from "%s" to "%s"', $targetName, $field['Comment'], $comment));
                        $io->newLine();
                        $success = false;
                    }
                    $default = $new['options']['default'];
                    if ($field['Default'] === 'current_timestamp()')
                        $field['Default'] = 'CURRENT_TIMESTAMP';
                    if ($default === 'current_timestamp()')
                        $default = 'CURRENT_TIMESTAMP';
                    if (strval($field['Default']) !== strval($default))
                    {
                        $io->warning(sprintf('The field "%s" is changing the DEFAULT value from "%s" to "%s"', $targetName, $field['Default'], $default));
                        $io->newLine();
                        $success = false;
                    }
                    //Do the type
                    switch($new['type']) {
                        case 'bigint':
                        case 'smallint':
                        case 'integer':
                            if ($field['Type'] === strtolower($new['columnDefinition']))
                                break;

                            $new['columnDefinition'] = strtolower($new['columnDefinition']);
                            $new_zerofill = strpos($new['columnDefinition'], 'zerofill') === false ? false : true;
                            $exist_zerofill = strpos($field['Type'], 'zerofill') === false ? false : true;
                            if ($new_zerofill !== $exist_zerofill){
                                $io->warning(sprintf('The field "%s" is changing the ZEROFILL value to "%s"', $targetName, $new_zerofill ? 'true' : 'false'));
                                $io->newLine();
                                $success = false;
                                break;
                            }

                            $new_zerofill = strpos($new['columnDefinition'], 'unsigned') === false ? false : true;
                            $exist_zerofill = strpos($field['Type'], 'unsigned') === false ? false : true;
                            if ($new_zerofill !== $exist_zerofill){
                                $io->warning(sprintf('The field "%s" is changing the UNSIGNED value to "%s"', $targetName, $new_zerofill ? 'true' : 'false'));
                                $io->newLine();
                                $success = false;
                                break;
                            }
    
                            $new_int = intval(str_replace([' ','zerofill', 'unsigned', 'int(', ')'], '', $new['columnDefinition']));
                            $exist = intval(str_replace([' ','zerofill', 'unsigned', 'int(', ')'], '', $field['Type']));
                            if ($new_int !== $exist){
                                $io->warning(sprintf('The field "%s" is changing the INTEGER LENGTH value from "%s" to "%s"', $targetName, $exist, $new_int));
                                $io->newLine();
                                $success = false;
                                break;
                            }
                            dd(__LINE__,$field,$new);
                            break;
                        case 'time':
                        case 'date':
                        case 'datetime':
                        case 'text':
                        case 'simple_array':
                            break;
                        case 'decimal':
                            if (strpos($field['Type'], 'decimal') === 0) {
                                if ($field['Type'] === 'decimal('.$new['precision'].','.$new['scale'].')')
                                    break;
                            }
                            dd(__LINE__,$field,$new);
                            break;
                        case 'string':
                            if (strpos($field['Type'],'varchar') === 0) {
                                $type = 'varchar';
                                if ($new['length'])
                                    $type .= '(' . $new['length'] . ')';
                                else
                                    $type .= '(255)';
                                if ($field['Type'] === $type)
                                    break;
                                $length = intval(str_replace(['varchar(',')'], '', $field['Type']));
                                if (intval($new['length']) !== $length) {
                                    $io->warning(sprintf('The field "%s" is changing the LENGTH if the string from "%s" to "%s"', $targetName, $length, $new['length']));
                                    $io->newLine();
                                    $success = false;
                                    break;
                                }
                            }
                            if (strpos($field['Type'],'enum') === 0)
                                break;
                            $io->error(sprintf('The field "%s" is is defined as a "%s" but will be changed to a "%s".  These are not compatible.', $targetName, $field['Type'], $new['type']));
                            $io->newLine();
                            $success = false;
                            break;
                        default:
                            dd(__LINE__,$new,$field);
                    }
                }
            }
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
            ->addOption('columns', null, InputOption::VALUE_NONE, 'Dig deeper and compare all column settings in the table.')

        ;
    }

    /**
     * loadFromAssociatedMappings
     * @param $metadata
     * @param $targetName
     */
    private function loadFromAssociatedMappings($metadata, $targetName)
    {
        foreach($metadata->getAssociationMappings() as $w) {
            foreach ($w['joinColumns'] as $q=>$c) {
                if ($c['name'] === $targetName) {
                    return $w;
                }
                unset($w['joinColumns'][$q]);
            }
        }

        dd(__LINE__,sprintf( '"%s" was not found as an associated or direct field in the existing table.', $targetName));
    }
}
