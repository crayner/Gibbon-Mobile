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
 * Class PlannerEntryHomework
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PlannerEntryHomeworkRepository")
 * @ORM\Table(name="PlannerEntryHomework")
 * @ORM\HasLifecycleCallbacks()
 */
class PlannerEntryHomework
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonPlannerEntryHomeworkID", columnDefinition="INT(16) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var PlannerEntry|null
     * @ORM\ManyToOne(targetEntity="PlannerEntry")
     * @ORM\JoinColumn(name="gibbonPlannerEntryID", referencedColumnName="gibbonPlannerEntryID")
     */
    private $plannerEntry;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=4)
     */
    private $type;

    /**
     * @var array
     */
    private static $typeList = ['Link', 'File'];

    /**
     * @var string|null
     * @ORM\Column(length=5)
     */
    private $version;

    /**
     * @var array
     */
    private static $versionList = ['Draft', 'Final'];

    /**
     * @var string|null
     * @ORM\Column(length=9)
     */
    private $status;

    /**
     * @var array
     */
    private static $statusList = ['On Time', 'Late', 'Exemption'];

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    private $location;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", columnDefinition="INT(1)")
     */
    private $count;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
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
     * @return PlannerEntryHomework
     */
    public function setId(?int $id): PlannerEntryHomework
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return PlannerEntry|null
     */
    public function getPlannerEntry(): ?PlannerEntry
    {
        return $this->plannerEntry;
    }

    /**
     * @param PlannerEntry|null $plannerEntry
     * @return PlannerEntryHomework
     */
    public function setPlannerEntry(?PlannerEntry $plannerEntry): PlannerEntryHomework
    {
        $this->plannerEntry = $plannerEntry;
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
     * @return PlannerEntryHomework
     */
    public function setPerson(?Person $person): PlannerEntryHomework
    {
        $this->person = $person;
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
     * @return PlannerEntryHomework
     */
    public function setType(?string $type): PlannerEntryHomework
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @param string|null $version
     * @return PlannerEntryHomework
     */
    public function setVersion(?string $version): PlannerEntryHomework
    {
        $this->version = in_array($version, self::getVersionList()) ? $version : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return PlannerEntryHomework
     */
    public function setStatus(?string $status): PlannerEntryHomework
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     * @return PlannerEntryHomework
     */
    public function setLocation(?string $location): PlannerEntryHomework
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int|null $count
     * @return PlannerEntryHomework
     */
    public function setCount(?int $count): PlannerEntryHomework
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    /**
     * setTimestamp
     * @param \DateTime|null $timestamp
     * @return PlannerEntryHomework
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestamp(?\DateTime $timestamp = null): PlannerEntryHomework
    {
        $this->timestamp = $timestamp ?: new \DateTime('now');
        return $this;
    }

    /**
     * @return array
     */
    public static function getTypeList(): array
    {
        return self::$typeList;
    }

    /**
     * @return array
     */
    public static function getVersionList(): array
    {
        return self::$versionList;
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }
}