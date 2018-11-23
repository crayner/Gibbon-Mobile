<?php
/**
 * Created by PhpStorm.
 *
 * This file is part of the Busybee Project.
 *
 * (c) Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 11:17
 */
namespace App\Doctrine\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class TablePrefixSubscriber implements EventSubscriber
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * TablePrefixSubscriber constructor.
     *
     * @param $prefix
     */
    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array('loadClassMetadata');
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        if (empty($this->prefix)) return;

        $classMetadata = $eventArgs->getClassMetadata();

        if (!$classMetadata->isInheritanceTypeSingleTable() || $classMetadata->getName() === $classMetadata->rootEntityName)
        {
            $tableName = $classMetadata->getTableName();
            if (strpos($tableName, $this->prefix) !== 0)
                $classMetadata->setPrimaryTable(['name' => $this->prefix . $tableName]);
        }
        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping)
            if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY && $mapping['isOwningSide'])
                if (strpos($mapping['joinTable']['name'], $this->prefix) !== 0)
                    $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mapping['joinTable']['name'];
    }
}