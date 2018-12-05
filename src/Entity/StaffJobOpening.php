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
 * Class StaffJobOpening
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StaffJobOpeningRepository")
 * @ORM\Table(name="StaffJobOpening")
 */
class StaffJobOpening
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonStaffJobOpeningID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(length=100, name="jobTitle")
     */
    private $jobTitle;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="jdateOpen")
     */
    private $dateOpen;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $active;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID")
     */
    private $personCreator;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampCreator", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestampCreator;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return StaffJobOpening
     */
    public function setId(?int $id): StaffJobOpening
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return StaffJobOpening
     */
    public function setType(?string $type): StaffJobOpening
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    /**
     * @param string|null $jobTitle
     * @return StaffJobOpening
     */
    public function setJobTitle(?string $jobTitle): StaffJobOpening
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateOpen(): ?\DateTime
    {
        return $this->dateOpen;
    }

    /**
     * @param \DateTime|null $dateOpen
     * @return StaffJobOpening
     */
    public function setDateOpen(?\DateTime $dateOpen): StaffJobOpening
    {
        $this->dateOpen = $dateOpen;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * @param string|null $active
     * @return StaffJobOpening
     */
    public function setActive(?string $active): StaffJobOpening
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return StaffJobOpening
     */
    public function setDescription(?string $description): StaffJobOpening
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonCreator(): ?Person
    {
        return $this->personCreator;
    }

    /**
     * @param Person|null $personCreator
     * @return StaffJobOpening
     */
    public function setPersonCreator(?Person $personCreator): StaffJobOpening
    {
        $this->personCreator = $personCreator;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampCreator(): ?\DateTime
    {
        return $this->timestampCreator;
    }

    /**
     * @param \DateTime|null $timestampCreator
     * @return StaffJobOpening
     */
    public function setTimestampCreator(?\DateTime $timestampCreator): StaffJobOpening
    {
        $this->timestampCreator = $timestampCreator;
        return $this;
    }
}