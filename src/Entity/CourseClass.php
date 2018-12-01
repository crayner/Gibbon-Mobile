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
 * Class CourseClass
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CourseClassRepository")
 * @ORM\Table(name="CourseClass", indexes={@ORM\Index(name="gibbonCourseID", columns={"gibbonCourseID"})})
 */
class CourseClass
{
    use BooleanList;
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="smallint", name="gibbonCourseClassID", columnDefinition="INT(3) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Course|null
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumn(name="gibbonCourseID", referencedColumnName="gibbonCourseID")
     */
    private $course;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=8, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $reportable = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $attendance = 'Y';

    /**
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleIDTarget", referencedColumnName="gibbonScaleID")
     */
    private $scale;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return CourseClass
     */
    public function setId(?int $id): CourseClass
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Course|null
     */
    public function getCourse(): ?Course
    {
        return $this->course;
    }

    /**
     * @param Course|null $course
     * @return CourseClass
     */
    public function setCourse(?Course $course): CourseClass
    {
        $this->course = $course;
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
     * @return CourseClass
     */
    public function setName(?string $name): CourseClass
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
     * @return CourseClass
     */
    public function setNameShort(?string $nameShort): CourseClass
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReportable(): ?string
    {
        return $this->reportable;
    }

    /**
     * @param string|null $reportable
     * @return CourseClass
     */
    public function setReportable(?string $reportable): CourseClass
    {
        $this->reportable = self::checkBoolean($reportable, 'Y');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttendance(): ?string
    {
        return $this->attendance;
    }

    /**
     * @param string|null $attendance
     * @return CourseClass
     */
    public function setAttendance(?string $attendance): CourseClass
    {
        $this->attendance = self::checkBoolean($attendance, 'Y');
        return $this;
    }

    /**
     * @return Scale|null
     */
    public function getScale(): ?Scale
    {
        return $this->scale;
    }

    /**
     * @param Scale|null $scale
     * @return CourseClass
     */
    public function setScale(?Scale $scale): CourseClass
    {
        $this->scale = $scale;
        return $this;
    }
}