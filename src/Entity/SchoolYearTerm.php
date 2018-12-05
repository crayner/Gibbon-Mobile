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
 * Class SchoolYearTerm
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SchoolYearTermRepository")
 * @ORM\Table(name="SchoolYearTerm", uniqueConstraints={@ORM\UniqueConstraint(name="sequenceNumber", columns={"sequenceNumber","gibbonSchoolYearID"})})
 */
class SchoolYearTerm
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonSchoolYearTermID", columnDefinition="INT(5) UNSIGNED ZEROFILL")
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
     * @var integer
     * @ORM\Column(type="smallint",columnDefinition="INT(5)",name="sequenceNumber")
     */
    private $sequenceNumber;

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=4, name="nameShort")
     */
    private $nameShort;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="firstDay")
     */
    private $firstDay;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="lastDay")
     */
    private $lastDay;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return SchoolYearTerm
     */
    public function setId(?int $id): SchoolYearTerm
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
     * @return SchoolYearTerm
     */
    public function setSchoolYear(?SchoolYear $schoolYear): SchoolYearTerm
    {
        $this->schoolYear = $schoolYear;
        return $this;
    }

    /**
     * @return int
     */
    public function getSequenceNumber(): int
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int $sequenceNumber
     * @return SchoolYearTerm
     */
    public function setSequenceNumber(int $sequenceNumber): SchoolYearTerm
    {
        $this->sequenceNumber = $sequenceNumber;
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
     * @return SchoolYearTerm
     */
    public function setName(?string $name): SchoolYearTerm
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
     * @return SchoolYearTerm
     */
    public function setNameShort(?string $nameShort): SchoolYearTerm
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getFirstDay(): ?\DateTime
    {
        return $this->firstDay;
    }

    /**
     * @param \DateTime|null $firstDay
     * @return SchoolYearTerm
     */
    public function setFirstDay(?\DateTime $firstDay): SchoolYearTerm
    {
        $this->firstDay = $firstDay;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastDay(): ?\DateTime
    {
        return $this->lastDay;
    }

    /**
     * @param \DateTime|null $lastDay
     * @return SchoolYearTerm
     */
    public function setLastDay(?\DateTime $lastDay): SchoolYearTerm
    {
        $this->lastDay = $lastDay;
        return $this;
    }
}