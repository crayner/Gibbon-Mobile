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
 * Class SpacePerson
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SpacePersonRepository")
 * @ORM\Table(name="SpacePerson")
 */
class SpacePerson
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonSpacePersonID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Space|null
     * @ORM\ManyToOne(targetEntity="Space")
     * @ORM\JoinColumn(name="gibbonSpaceID", referencedColumnName="gibbonSpaceID", nullable=false)
     */
    private $space;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=8, name="usageType", nullable=true)
     */
    private $usageType;

    /**
     * @var array
     */
    private static $usageTypeList = ['', 'Teaching', 'Office', 'Other'];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return SpacePerson
     */
    public function setId(?int $id): SpacePerson
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Space|null
     */
    public function getSpace(): ?Space
    {
        return $this->space;
    }

    /**
     * @param Space|null $space
     * @return SpacePerson
     */
    public function setSpace(?Space $space): SpacePerson
    {
        $this->space = $space;
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
     * @return SpacePerson
     */
    public function setPerson(?Person $person): SpacePerson
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsageType(): ?string
    {
        return $this->usageType;
    }

    /**
     * @param string|null $usageType
     * @return SpacePerson
     */
    public function setUsageType(?string $usageType): SpacePerson
    {
        $this->usageType = in_array($usageType, self::getUsageTypeList()) ? $usageType : null;
        return $this;
    }

    /**
     * @return array
     */
    public static function getUsageTypeList(): array
    {
        return self::$usageTypeList;
    }
}