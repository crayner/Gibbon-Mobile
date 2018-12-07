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
 * Date: 7/12/2018
 * Time: 15:03
 */
namespace App\Provider;

use App\Entity\Role;
use App\Manager\Traits\EntityTrait;

/**
 * Class RoleProvider
 * @package App\Provider
 */
class RoleProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Role::class;

    /**
     * @var array
     */
    private $allRoles = [];

    /**
     * getRoleCategory
     * @param int $roleID
     * @return string
     */
    public function getRoleCategory(int $roleID): string
    {
        if (! empty($this->getAllRoles()[intval($roleID)]))
            return $this->getAllRoles()[intval($roleID)]->getCategory();
        return '';
    }

    /**
     * getAllRoles
     * @return array
     * @throws \Exception
     */
    public function getAllRoles(): array
    {
        if (empty($this->allRoles)) {
            $allRoles = $this->getRepository()->createQueryBuilder('r', 'r.id')
                ->getQuery()
                ->getResult() ?: [];
            foreach($allRoles as $q=>$role)
                $this->allRoles[intval($q)] = $role;
        }
        return $this->allRoles;
    }

    /**
     * additionalConstruct
     * @throws \Exception
     */
    private function additionalConstruct()
    {
        $this->getAllRoles();
        dump($this);
    }
}