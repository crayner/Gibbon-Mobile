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
 * Time: 17:26
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TTSpaceChange
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTSpaceChangeRepository")
 * @ORM\Table(name="TTSpaceChange", indexes={@ORM\Index(name="gibbonTTDayRowClassID", columns={"gibbonTTDayRowClassID"}), @ORM\Index(name="date", columns={"date"})})
 */
class TTSpaceChange
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonTTSpaceChangeID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var TTDayRowClass|null
     * @ORM\ManyToOne(targetEntity="TTDayRowClass")
     * @ORM\JoinColumn(name="gibbonTTDayRowClassID", referencedColumnName="gibbonTTDayRowClassID")
     */
    private $TTDayRowClass;

    /**
     * @var Space|null
     * @ORM\ManyToOne(targetEntity="Space")
     * @ORM\JoinColumn(name="gibbonSpaceID",referencedColumnName="gibbonSpaceID",nullable=true)
     */
    private $space;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $date;

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
     * @return TTSpaceChange
     */
    public function setId(?int $id): TTSpaceChange
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return TTDayRowClass|null
     */
    public function getTTDayRowClass(): ?TTDayRowClass
    {
        return $this->TTDayRowClass;
    }

    /**
     * @param TTDayRowClass|null $TTDayRowClass
     * @return TTSpaceChange
     */
    public function setTTDayRowClass(?TTDayRowClass $TTDayRowClass): TTSpaceChange
    {
        $this->TTDayRowClass = $TTDayRowClass;
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
     * @return TTSpaceChange
     */
    public function setSpace(?Space $space): TTSpaceChange
    {
        $this->space = $space;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     * @return TTSpaceChange
     */
    public function setDate(?\DateTime $date): TTSpaceChange
    {
        $this->date = $date;
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
     * @return TTSpaceChange
     */
    public function setPerson(?Person $person): TTSpaceChange
    {
        $this->person = $person;
        return $this;
    }
}