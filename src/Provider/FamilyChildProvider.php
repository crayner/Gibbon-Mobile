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
 * Date: 12/12/2018
 * Time: 10:26
 */
namespace App\Provider;

use App\Entity\Family;
use App\Entity\FamilyChild;
use App\Entity\Person;
use App\Manager\Traits\EntityTrait;
use Doctrine\DBAL\Connection;

/**
 * Class FamilyChildProvider
 * @package App\Provider
 */
class FamilyChildProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = FamilyChild::class;

    /**
     * getChildrenFromParent
     * @param Person $person
     * @return array
     */
    public function getChildrenFromParent(Person $person): array
    {
        $result =  $this->getRepository()->createQueryBuilder('fc')
            ->leftJoin('fc.family', 'f')
            ->leftJoin('f.adults', 'fa')
            ->where('fa.person = :person')
            ->setParameter('person', $person)
            ->getQuery()
            ->getResult();

        $children = [];
        foreach($result as $child)
            $children[] = $child->getPerson()->getId();

        return $children;
    }
}