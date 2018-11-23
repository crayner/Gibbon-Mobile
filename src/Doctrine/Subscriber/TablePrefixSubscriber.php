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