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
 * Class AttendanceLogRollGroup
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AttendanceLogRollGroupRepository")
 * @ORM\Table(name="AttendanceLogRollGroup")
 * @ORM\HasLifecycleCallbacks
 */
class AttendanceLogRollGroup
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonAttendanceLogRollGroupID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var RollGroup|null
     * @ORM\ManyToOne(targetEntity="RollGroup")
     * @ORM\JoinColumn(name="gibbonRollGroupID", referencedColumnName="gibbonRollGroupID")
     */
    private $rollGroup;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTaker", referencedColumnName="gibbonPersonID")
     */
    private $personTaker;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampTaken")
     */
    private $timestampTaken;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return AttendanceLogRollGroup
     */
    public function setId(?int $id): AttendanceLogRollGroup
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return RollGroup|null
     */
    public function getRollGroup(): ?RollGroup
    {
        return $this->rollGroup;
    }

    /**
     * @param RollGroup|null $rollGroup
     * @return AttendanceLogRollGroup
     */
    public function setRollGroup(?RollGroup $rollGroup): AttendanceLogRollGroup
    {
        $this->rollGroup = $rollGroup;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonTaker(): ?Person
    {
        return $this->personTaker;
    }

    /**
     * @param Person|null $personTaker
     * @return AttendanceLogRollGroup
     */
    public function setPersonTaker(?Person $personTaker): AttendanceLogRollGroup
    {
        $this->personTaker = $personTaker;
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
     * @return AttendanceLogRollGroup
     */
    public function setDate(?\DateTime $date): AttendanceLogRollGroup
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampTaken(): ?\DateTime
    {
        return $this->timestampTaken;
    }

    /**
     * @param \DateTime|null $timestampTaken
     * @return AttendanceLogRollGroup
     */
    public function setTimestampTaken(?\DateTime $timestampTaken): AttendanceLogRollGroup
    {
        $this->timestampTaken = $timestampTaken;
        return $this;
    }

    /**
     * updateTakenTime
     * @return AttendanceLogRollGroup
     * @throws \Exception
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTakenTime(): AttendanceLogRollGroup
    {
        return $this->setTimestampTaken(new \DateTime('now'));
    }
}