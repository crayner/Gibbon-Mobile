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
 * Class ActivityAttendance
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ActivityAttendanceRepository")
 * @ORM\Table(name="ActivityAttendance")
 */
class ActivityAttendance
{

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonActivityAttendanceID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ActivityAttendance
     */
    public function setId(?int $id): ActivityAttendance
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity")
     * @ORM\JoinColumn(name="gibbonActivityID",referencedColumnName="gibbonActivityID")
     */
    private $activity;

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return ActivityAttendance
     */
    public function setActivity(?Activity $activity): ActivityAttendance
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTaker",referencedColumnName="gibbonPersonID")
     */
    private $personTaker;

    /**
     * @return Person|null
     */
    public function getPersonTaker(): ?Person
    {
        return $this->personTaker;
    }

    /**
     * @param Person|null $personTaker
     * @return ActivityAttendance
     */
    public function setPersonTaker(?Person $personTaker): ActivityAttendance
    {
        $this->personTaker = $personTaker;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $attendance;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @return string|null
     */
    public function getAttendance(): ?string
    {
        return $this->attendance;
    }

    /**
     * @param string|null $attendance
     * @return ActivityAttendance
     */
    public function setAttendance(?string $attendance): ActivityAttendance
    {
        $this->attendance = $attendance;
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
     * @return ActivityAttendance
     */
    public function setDate(?\DateTime $date): ActivityAttendance
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampTaken")
     */
    private $timestampTaken;

    /**
     * @return \DateTime|null
     */
    public function getTimestampTaken(): ?\DateTime
    {
        return $this->timestampTaken;
    }

    /**
     * @param \DateTime|null $timestampTaken
     * @return ActivityAttendance
     */
    public function setTimestampTaken(?\DateTime $timestampTaken): ActivityAttendance
    {
        $this->timestampTaken = $timestampTaken;
        return $this;
    }

    /**
     * updateTimestampTaken
     * @return $this
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @throws \Exception
     */
    public function updateTimestampTaken()
    {
        $this->setTimestampTaken(new \DateTime('now'));
        return $this;
    }
}