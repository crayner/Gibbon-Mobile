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

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PlannerParentWeeklyEmailSummary
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PlannerParentWeeklyEmailSummaryRepository")
 * @ORM\Table(name="PlannerParentWeeklyEmailSummary", uniqueConstraints={@ORM\UniqueConstraint(name="key", columns={"key"})})
 */
class PlannerParentWeeklyEmailSummary
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonPlannerParentWeeklyEmailSummaryID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=false)
     */
    private $schoolYear;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDParent", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $parent;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDStudent",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $student;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="weekOfYear", columnDefinition="INT(2)")
     */
    private $weekOfYear;

    /**
     * @var string|null
     * @ORM\Column(length=40, unique=true)
     */
    private $key;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $confirmed = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PlannerParentWeeklyEmailSummary
     */
    public function setId(?int $id): PlannerParentWeeklyEmailSummary
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return SchoolYear|null
     */
    public function getSchoolYear(): ?SchoolYear
    {
        return $this->schoolYear;
    }

    /**
     * @param SchoolYear|null $schoolYear
     * @return PlannerParentWeeklyEmailSummary
     */
    public function setSchoolYear(?SchoolYear $schoolYear): PlannerParentWeeklyEmailSummary
    {
        $this->schoolYear = $schoolYear;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getParent(): ?Person
    {
        return $this->parent;
    }

    /**
     * @param Person|null $parent
     * @return PlannerParentWeeklyEmailSummary
     */
    public function setParent(?Person $parent): PlannerParentWeeklyEmailSummary
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getStudent(): ?Person
    {
        return $this->student;
    }

    /**
     * @param Person|null $student
     * @return PlannerParentWeeklyEmailSummary
     */
    public function setStudent(?Person $student): PlannerParentWeeklyEmailSummary
    {
        $this->student = $student;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeekOfYear(): ?int
    {
        return $this->weekOfYear;
    }

    /**
     * @param int|null $weekOfYear
     * @return PlannerParentWeeklyEmailSummary
     */
    public function setWeekOfYear(?int $weekOfYear): PlannerParentWeeklyEmailSummary
    {
        $this->weekOfYear = $weekOfYear;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     * @return PlannerParentWeeklyEmailSummary
     */
    public function setKey(?string $key): PlannerParentWeeklyEmailSummary
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getConfirmed(): ?string
    {
        return $this->confirmed;
    }

    /**
     * @param string|null $confirmed
     * @return PlannerParentWeeklyEmailSummary
     */
    public function setConfirmed(?string $confirmed): PlannerParentWeeklyEmailSummary
    {
        $this->confirmed = $confirmed;
        return $this;
    }
}