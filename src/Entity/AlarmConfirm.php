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
 * Class AlarmConfirm
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AlarmConfirmRepository")
 * @ORM\Table(name="AlarmConfirm")
 * @ORM\HasLifecycleCallbacks
 */
class AlarmConfirm
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonAlarmConfirmID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Alarm|null
     * @ORM\ManyToOne(targetEntity="Alarm")
     * @ORM\JoinColumn(name="gibbonAlarmID",referencedColumnName="gibbonAlarmID")
     */
    private $alarm;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return AlarmConfirm
     */
    public function setId(?int $id): AlarmConfirm
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Alarm|null
     */
    public function getAlarm(): ?Alarm
    {
        return $this->alarm;
    }

    /**
     * @param Alarm|null $alarm
     * @return AlarmConfirm
     */
    public function setAlarm(?Alarm $alarm): AlarmConfirm
    {
        $this->alarm = $alarm;
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
     * @return AlarmConfirm
     */
    public function setPerson(?Person $person): AlarmConfirm
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime $timestamp
     * @return AlarmConfirm
     */
    public function setTimestamp(\DateTime $timestamp): AlarmConfirm
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * updateTimestamp
     * @return AlarmConfirm
     * @throws \Exception
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTimestamp()
    {
        return $this->setTimestamp(new \DateTime('now'));
    }
}