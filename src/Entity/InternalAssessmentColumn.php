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
 * Class InternalAssessmentColumn
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\InternalAssessmentColumnRepository")
 * @ORM\Table(name="InternalAssessmentColumn")
 */
class InternalAssessmentColumn
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonInternalAssessmentColumnID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var CourseClass|null
     * @ORM\ManyToOne(targetEntity="CourseClass")
     * @ORM\JoinColumn(name="gibbonCourseClassID", referencedColumnName="gibbonCourseClassID")
     */
    private $courseClass;

    /**
     * @var integer|null
     * @ORM\Column(nullable=true, columnDefinition="INT(8)", options={"comment": "A value used to group multiple columns."}, name="groupingID")
     */
    private $groupingID;

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $attachment;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $attainment = 'Y';

    /**
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleIDAttainment", referencedColumnName="gibbonScaleID", nullable=true)
     */
    private $scaleAttainment;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $effort = 'Y';

    /**
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleIDEffort", referencedColumnName="gibbonScaleID", nullable=true)
     */
    private $scaleEffort;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $comment = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="uploadedResponse")
     */
    private $uploadedResponse = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $complete = 'N';

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="completeDate", nullable=true)
     */
    private $completeDate;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="viewableStudents")
     */
    private $viewableStudents = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="viewableParents")
     */
    private $viewableParents = 'N';

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID")
     */
    private $creator;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDLastEdit", referencedColumnName="gibbonPersonID")
     */
    private $lastEdit;
}