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
 * Class MarkbookWeight
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MarkbookWeightRepository")
 * @ORM\Table(name="MarkbookWeight")
 */
class MarkbookWeight
{
    use BooleanList;
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonMarkbookWeightID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
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
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $reportable = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=4)
     */
    private $calculate = 'year';

    /**
     * @var array
     */
    private static $calculateList = ['term','year'];

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $weighting;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return MarkbookWeight
     */
    public function setId(?int $id): MarkbookWeight
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return CourseClass|null
     */
    public function getCourseClass(): ?CourseClass
    {
        return $this->courseClass;
    }

    /**
     * @param CourseClass|null $courseClass
     * @return MarkbookWeight
     */
    public function setCourseClass(?CourseClass $courseClass): MarkbookWeight
    {
        $this->courseClass = $courseClass;
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
     * @return MarkbookWeight
     */
    public function setType(?string $type): MarkbookWeight
    {
        $this->type = $type;
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
     * @return MarkbookWeight
     */
    public function setDescription(?string $description): MarkbookWeight
    {
        $this->description = $description;
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
     * @return MarkbookWeight
     */
    public function setReportable(?string $reportable): MarkbookWeight
    {
        $this->reportable = self::checkBoolean($reportable);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCalculate(): ?string
    {
        return $this->calculate;
    }

    /**
     * @param string|null $calculate
     * @return MarkbookWeight
     */
    public function setCalculate(?string $calculate): MarkbookWeight
    {
        $this->calculate = in_array($calculate, self::getCalculateList()) ? $calculate : 'year';
        return $this;
    }

    /**
     * @return float|null
     */
    public function getWeighting(): ?float
    {
        return $this->weighting;
    }

    /**
     * @param float|null $weighting
     * @return MarkbookWeight
     */
    public function setWeighting(?float $weighting): MarkbookWeight
    {
        $this->weighting = $weighting;
        return $this;
    }

    /**
     * @return array
     */
    public static function getCalculateList(): array
    {
        return self::$calculateList;
    }
}