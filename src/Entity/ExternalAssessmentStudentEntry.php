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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ExternalAssessmentStudentEntry
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ExternalAssessmentStudentEntryRepository")
 * @ORM\Table(name="ExternalAssessmentStudentEntry", indexes={@ORM\Index(name="gibbonExternalAssessmentStudentID", columns={"gibbonExternalAssessmentStudentID"}),@ORM\Index(name="gibbonExternalAssessmentFieldID", columns={"gibbonExternalAssessmentFieldID"}),@ORM\Index(name="gibbonScaleGradeID", columns={"gibbonScaleGradeID"})})
 */
class ExternalAssessmentStudentEntry
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonExternalAssessmentStudentEntryID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var ExternalAssessmentStudent|null
     * @ORM\ManyToOne(targetEntity="ExternalAssessmentStudent")
     * @ORM\JoinColumn(name="gibbonExternalAssessmentStudentID", referencedColumnName="gibbonExternalAssessmentStudentID", nullable=false)
     */
    private $externalAssessmentStudent;

    /**
     * @var ExternalAssessmentField|null
     * @ORM\ManyToOne(targetEntity="ExternalAssessmentField")
     * @ORM\JoinColumn(name="gibbonExternalAssessmentFieldID", referencedColumnName="gibbonExternalAssessmentFieldID", nullable=false)
     */
    private $externalAssessmentField;

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
     * @return ExternalAssessmentStudentEntry
     */
    public function setId(?int $id): ExternalAssessmentStudentEntry
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ExternalAssessmentStudent|null
     */
    public function getExternalAssessmentStudent(): ?ExternalAssessmentStudent
    {
        return $this->externalAssessmentStudent;
    }

    /**
     * @param ExternalAssessmentStudent|null $externalAssessmentStudent
     * @return ExternalAssessmentStudentEntry
     */
    public function setExternalAssessmentStudent(?ExternalAssessmentStudent $externalAssessmentStudent): ExternalAssessmentStudentEntry
    {
        $this->externalAssessmentStudent = $externalAssessmentStudent;
        return $this;
    }

    /**
     * @return ExternalAssessmentField|null
     */
    public function getExternalAssessmentField(): ?ExternalAssessmentField
    {
        return $this->externalAssessmentField;
    }

    /**
     * @param ExternalAssessmentField|null $externalAssessmentField
     * @return ExternalAssessmentStudentEntry
     */
    public function setExternalAssessmentField(?ExternalAssessmentField $externalAssessmentField): ExternalAssessmentStudentEntry
    {
        $this->externalAssessmentField = $externalAssessmentField;
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
     * @return ExternalAssessmentStudentEntry
     */
    public function setScaleGrade(?ScaleGrade $scaleGrade): ExternalAssessmentStudentEntry
    {
        $this->scaleGrade = $scaleGrade;
        return $this;
    }
}