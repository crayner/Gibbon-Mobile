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
 * Class Course
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 * @ORM\Table(name="Course", indexes={@ORM\Index(name="gibbonSchoolYearID", columns={"gibbonSchoolYearID"})}, uniqueConstraints={@ORM\UniqueConstraint(name="nameYear",columns={ "gibbonSchoolYearID", "name"})})
 */
class Course
{
    use BooleanList;
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonCourseID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID")
     */
    private $schoolYear;

    /**
     * @var Department|null
     * @ORM\ManyToOne(targetEntity="Department")
     * @ORM\JoinColumn(name="gibbonDepartmentID", referencedColumnName="gibbonDepartmentID")
     */
    private $department;

    /**
     * @var string|null
     * @ORM\Column(length=60)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=12, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $map;

    /**
     * @var string|null
     * @ORM\Column(name="gibbonYearGroupIDList")
     */
    private $yearGroupList;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="orderBy", columnDefinition="INT(3)")
     */
    private $orderBy;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Course
     */
    public function setId(?int $id): Course
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
     * @return Course
     */
    public function setSchoolYear(?SchoolYear $schoolYear): Course
    {
        $this->schoolYear = $schoolYear;
        return $this;
    }

    /**
     * @return Department|null
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    /**
     * @param Department|null $department
     * @return Course
     */
    public function setDepartment(?Department $department): Course
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Course
     */
    public function setName(?string $name): Course
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameShort(): ?string
    {
        return $this->nameShort;
    }

    /**
     * @param string|null $nameShort
     * @return Course
     */
    public function setNameShort(?string $nameShort): Course
    {
        $this->nameShort = $nameShort;
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
     * @return Course
     */
    public function setDescription(?string $description): Course
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMap(): ?string
    {
        return $this->map;
    }

    /**
     * @param string|null $map
     * @return Course
     */
    public function setMap(?string $map): Course
    {
        $this->map = $map;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getYearGroupList(): ?string
    {
        return $this->yearGroupList;
    }

    /**
     * @param string|null $yearGroupList
     * @return Course
     */
    public function setYearGroupList(?string $yearGroupList): Course
    {
        $this->yearGroupList = $yearGroupList;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderBy(): ?int
    {
        return $this->orderBy;
    }

    /**
     * @param int|null $orderBy
     * @return Course
     */
    public function setOrderBy(?int $orderBy): Course
    {
        $this->orderBy = $orderBy;
        return $this;
    }
}