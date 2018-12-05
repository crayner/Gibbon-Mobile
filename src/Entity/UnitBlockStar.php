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
 * Date: 5/12/2018
 * Time: 22:02
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UnitBlockStar
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UnitBlockStarRepository")
 * @ORM\Table(name="UnitBlockStar")
 */
class UnitBlockStar
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonUnitBlockStarID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var UnitBlock|null
     * @ORM\ManyToOne(targetEntity="UnitBlock")
     * @ORM\JoinColumn(name="gibbonUnitBlockID", referencedColumnName="gibbonUnitBlockID")
     */
    private $unitBlock;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UnitBlockStar
     */
    public function setId(?int $id): UnitBlockStar
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return UnitBlock|null
     */
    public function getUnitBlock(): ?UnitBlock
    {
        return $this->unitBlock;
    }

    /**
     * @param UnitBlock|null $unitBlock
     * @return UnitBlockStar
     */
    public function setUnitBlock(?UnitBlock $unitBlock): UnitBlockStar
    {
        $this->unitBlock = $unitBlock;
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
     * @return UnitBlockStar
     */
    public function setPerson(?Person $person): UnitBlockStar
    {
        $this->person = $person;
        return $this;
    }
}