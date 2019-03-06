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
namespace App\Util;

use App\Manager\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EntityHelper
 * @package App\Util
 */
class EntityHelper
{
    /**
     * @var EntityManagerInterface
     */
    private static $entityManager;

    /**
     * EntityHelper constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        self::$entityManager = $entityManager;
    }

    /**
     * getRepository
     * @param string $className
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public static function getRepository(string $className)
    {
        return self::getEntityManager()->getRepository($className);
    }

    /**
     * @return EntityManagerInterface
     */
    public static function getEntityManager(): EntityManagerInterface
    {
        return self::$entityManager;
    }

    /**
     * __toArray
     * @param string $entityName
     * @param array $ignore
     * @return array
     */
    public static function __toArray(string $entityName, EntityInterface $data, array $ignore = []): array
    {
        $event = (array) $data;
        $ignore = array_merge(['__initializer__','__cloner__','__isInitialized__'], $ignore);
        foreach($event as $q=>$w)
        {
            unset($event[$q]);
            $id = str_replace("\x00".$entityName."\x00", '',  $q);
            if (! in_array($id, $ignore))
                $event[$id] = $w;
        }

        return $event;
    }
}