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
 * Date: 19/12/2018
 * Time: 12:18
 */
namespace App\Provider;

use App\Entity\Action;
use App\Manager\EntityProviderInterface;
use App\Manager\Traits\EntityTrait;

/**
 * Class ActionProvider
 * @package App\Provider
 */
class ActionProvider implements EntityProviderInterface
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Action::class;

    /**
     * findByURLListModuleRole
     * @param array $criteria
     * @return mixed
     * @throws \Exception
     */
    public function findByURLListModuleRole(array $criteria)
    {
        return $this->getRepository()->createQueryBuilder('a')
            ->join('a.permissions', 'p')
            ->join('p.role', 'r')
            ->where('a.URLList LIKE :name')
            ->andWhere('a.module = :module')
            ->andWhere('p.role = :role')
            ->andWhere('a.name LIKE :sub')
            ->setParameters($criteria)
            ->getQuery()
            ->getArrayResult();
    }
}