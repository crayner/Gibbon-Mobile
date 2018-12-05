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

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PlannerEntryStudentHomework
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PlannerEntryStudentHomeworkRepository")
 * @ORM\Table(name="PlannerEntryStudentHomework", indexes={@ORM\Index(name="gibbonPlannerEntryID", columns={"gibbonPlannerEntryID","gibbonPersonID"})})
 */
class PlannerEntryStudentHomework
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonPlannerEntryStudentHomeworkID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
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
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="homeworkDueDateTime")
     */
    private $homeworkDueDateTime;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="homeworkDetails")
     */
    private $homeworkDetails;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="homeworkComplete")
     */
    private $homeworkComplete = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PlannerEntryStudentHomework
     */
    public function setId(?int $id): PlannerEntryStudentHomework
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
     * @return PlannerEntryStudentHomework
     */
    public function setPlannerEntry(?PlannerEntry $plannerEntry): PlannerEntryStudentHomework
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
     * @return PlannerEntryStudentHomework
     */
    public function setPerson(?Person $person): PlannerEntryStudentHomework
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getHomeworkDueDateTime(): ?\DateTime
    {
        return $this->homeworkDueDateTime;
    }

    /**
     * @param \DateTime|null $homeworkDueDateTime
     * @return PlannerEntryStudentHomework
     */
    public function setHomeworkDueDateTime(?\DateTime $homeworkDueDateTime): PlannerEntryStudentHomework
    {
        $this->homeworkDueDateTime = $homeworkDueDateTime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkDetails(): ?string
    {
        return $this->homeworkDetails;
    }

    /**
     * @param string|null $homeworkDetails
     * @return PlannerEntryStudentHomework
     */
    public function setHomeworkDetails(?string $homeworkDetails): PlannerEntryStudentHomework
    {
        $this->homeworkDetails = $homeworkDetails;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkComplete(): ?string
    {
        return $this->homeworkComplete;
    }

    /**
     * @param string|null $homeworkComplete
     * @return PlannerEntryStudentHomework
     */
    public function setHomeworkComplete(?string $homeworkComplete): PlannerEntryStudentHomework
    {
        $this->homeworkComplete = self::checkBoolean($homeworkComplete, 'N');
        return $this;
    }
}