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
 * Class RollGroup
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RollGroupRepository")
 * @ORM\Table(name="RollGroup")
 */
class RollGroup
{
    use BooleanList;
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="smallint", name="gibbonRollGroupID", columnDefinition="INT(5) UNSIGNED ZEROFILL")
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
     * @var string|null
     * @ORM\Column(length=10)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=5, name="nameShort")
     */
    private $nameShort;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTutoe",referencedColumnName="gibbonPersonID", nullable=true)
     */
    private $tutor;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTutoe2",referencedColumnName="gibbonPersonID", nullable=true)
     */
    private $tutor2;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTutor3",referencedColumnName="gibbonPersonID", nullable=true)
     */
    private $tutoe3;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDEA",referencedColumnName="gibbonPersonID", nullable=true)
     */
    private $assistant;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDEA2",referencedColumnName="gibbonPersonID", nullable=true)
     */
    private $assistant2;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDEA3",referencedColumnName="gibbonPersonID", nullable=true)
     */
    private $assistant3;

    /**
     * @var Space|null
     * @ORM\ManyToOne(targetEntity="Space")
     * @ORM\JoinColumn(name="gibbonSpaceID", referencedColumnName="gibbonSpaceID", nullable=true)
     */
    private $space;

    /**
     * @var RollGroup|null
     * @ORM\ManyToOne(targetEntity="RollGroup")
     * @ORM\JoinColumn(name="gibbonRollGroupIDNext", referencedColumnName="gibbonRollGroupID", nullable=true)
     */
    private $nextRollGroup;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $attendance = 'Y';

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $website;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return RollGroup
     */
    public function setId(?int $id): RollGroup
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
     * @return RollGroup
     */
    public function setSchoolYear(?SchoolYear $schoolYear): RollGroup
    {
        $this->schoolYear = $schoolYear;
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
     * @return RollGroup
     */
    public function setName(?string $name): RollGroup
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
     * @return RollGroup
     */
    public function setNameShort(?string $nameShort): RollGroup
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getTutor(): ?Person
    {
        return $this->tutor;
    }

    /**
     * @param Person|null $tutor
     * @return RollGroup
     */
    public function setTutor(?Person $tutor): RollGroup
    {
        $this->tutor = $tutor;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getTutor2(): ?Person
    {
        return $this->tutor2;
    }

    /**
     * @param Person|null $tutor2
     * @return RollGroup
     */
    public function setTutor2(?Person $tutor2): RollGroup
    {
        $this->tutor2 = $tutor2;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getTutoe3(): ?Person
    {
        return $this->tutoe3;
    }

    /**
     * @param Person|null $tutoe3
     * @return RollGroup
     */
    public function setTutoe3(?Person $tutoe3): RollGroup
    {
        $this->tutoe3 = $tutoe3;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getAssistant(): ?Person
    {
        return $this->assistant;
    }

    /**
     * @param Person|null $assistant
     * @return RollGroup
     */
    public function setAssistant(?Person $assistant): RollGroup
    {
        $this->assistant = $assistant;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getAssistant2(): ?Person
    {
        return $this->assistant2;
    }

    /**
     * @param Person|null $assistant2
     * @return RollGroup
     */
    public function setAssistant2(?Person $assistant2): RollGroup
    {
        $this->assistant2 = $assistant2;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getAssistant3(): ?Person
    {
        return $this->assistant3;
    }

    /**
     * @param Person|null $assistant3
     * @return RollGroup
     */
    public function setAssistant3(?Person $assistant3): RollGroup
    {
        $this->assistant3 = $assistant3;
        return $this;
    }

    /**
     * @return Space|null
     */
    public function getSpace(): ?Space
    {
        return $this->space;
    }

    /**
     * @param Space|null $space
     * @return RollGroup
     */
    public function setSpace(?Space $space): RollGroup
    {
        $this->space = $space;
        return $this;
    }

    /**
     * @return RollGroup|null
     */
    public function getNextRollGroup(): ?RollGroup
    {
        return $this->nextRollGroup;
    }

    /**
     * @param RollGroup|null $nextRollGroup
     * @return RollGroup
     */
    public function setNextRollGroup(?RollGroup $nextRollGroup): RollGroup
    {
        $this->nextRollGroup = $nextRollGroup;
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
     * @return RollGroup
     */
    public function setAttendance(?string $attendance): RollGroup
    {
        $this->attendance = self::checkBoolean($attendance);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string|null $website
     * @return RollGroup
     */
    public function setWebsite(?string $website): RollGroup
    {
        $this->website = $website;
        return $this;
    }
}