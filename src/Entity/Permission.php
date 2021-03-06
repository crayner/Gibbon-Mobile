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

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Permission
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PermissionRepository")
 * @ORM\Table(name="Permission", indexes={@ORM\Index(name="gibbonRoleID", columns={"gibbonRoleID"}), @ORM\Index(name="gibbonActionID", columns={"gibbonActionID"})})
 */
class Permission
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="permissionID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Role|null
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="gibbonRoleID", referencedColumnName="gibbonRoleID", nullable=false)
     */
    private $role;

    /**
     * @var Action|null
     * @ORM\ManyToOne(targetEntity="Action", inversedBy="permissions")
     * @ORM\JoinColumn(name="gibbonActionID", referencedColumnName="gibbonActionID", nullable=false)
     */
    private $action;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Permission
     */
    public function setId(?int $id): Permission
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * @param Role|null $role
     * @return Permission
     */
    public function setRole(?Role $role): Permission
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return Action|null
     */
    public function getAction(): ?Action
    {
        return $this->action;
    }

    /**
     * @param Action|null $action
     * @return Permission
     */
    public function setAction(?Action $action): Permission
    {
        $this->action = $action;
        return $this;
    }
}