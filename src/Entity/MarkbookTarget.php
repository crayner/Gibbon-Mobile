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
 * Class MarkbookTarget
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MarkbookTargetRepository")
 * @ORM\Table(name="MarkbookTarget", uniqueConstraints={@ORM\UniqueConstraint(name="coursePerson", columns={"gibbonCourseClassID", "gibbonPersonIDStudent"})})
 */
class MarkbookTarget
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonMarkbookTargetID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="CourseClass")
     * @ORM\JoinColumn(name="gibbonCourseClassID", referencedColumnName="gibbonCourseClassID")
     */
    private $courseClass;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDStudent", referencedColumnName="gibbonPersonID")
     */
    private $student;

    /**
     * @var ScaleGrade|null
     * @ORM\ManyToOne(targetEntity="ScaleGrade")
     * @ORM\JoinColumn(name="gibbonScaleGradeID", referencedColumnName="gibbonScaleGradeID")
     */
    private $scaleGrade;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return MarkbookTarget
     */
    public function setId(?int $id): MarkbookTarget
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getCourseClass(): ?Person
    {
        return $this->courseClass;
    }

    /**
     * @param Person|null $courseClass
     * @return MarkbookTarget
     */
    public function setCourseClass(?Person $courseClass): MarkbookTarget
    {
        $this->courseClass = $courseClass;
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
     * @return MarkbookTarget
     */
    public function setStudent(?Person $student): MarkbookTarget
    {
        $this->student = $student;
        return $this;
    }

    /**
     * @return ScaleGrade|null
     */
    public function getScaleGrade(): ?ScaleGrade
    {
        return $this->scaleGrade;
    }

    /**
     * @param ScaleGrade|null $scaleGrade
     * @return MarkbookTarget
     */
    public function setScaleGrade(?ScaleGrade $scaleGrade): MarkbookTarget
    {
        $this->scaleGrade = $scaleGrade;
        return $this;
    }
}