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
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ActivityStaff
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ActivityStaffRepository")
 * @ORM\Table(name="ActivityStaff")
 */
class ActivityStaff
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonActivityStaffID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity", inversedBy="staff")
     * @ORM\JoinColumn(name="gibbonActivityID",referencedColumnName="gibbonActivityID", nullable=false)
     */
    private $activity;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string
     * @ORM\Column(length=9, options={"default": "Organiser"})
     */
    private $role = 'Organiser';

    /**
     * @var array
     */
    private static $roleList = ['Organiser', 'Coach', 'Assistant', 'Other'];

    /**
     * @return array
     */
    public static function getRoleList(): array
    {
        return self::$roleList;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ActivityStaff
     */
    public function setId(?int $id): ActivityStaff
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return ActivityStaff
     */
    public function setActivity(?Activity $activity): ActivityStaff
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * @param Person|null $person
     * @return ActivityStaff
     */
    public function setPerson(?Person $person): ActivityStaff
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return ActivityStaff
     */
    public function setRole(string $role): ActivityStaff
    {
        $this->role = in_array($role, self::getRoleList()) ? $role : 'Organiser';
        return $this;
    }
}