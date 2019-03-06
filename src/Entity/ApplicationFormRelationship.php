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
 * Class ApplicationFormRelationship
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationFormRelationshipRepository")
 * @ORM\Table(name="ApplicationFormRelationship")
 */
class ApplicationFormRelationship
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonApplicationFormRelationshipID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var ApplicationForm|null
     * @ORM\ManyToOne(targetEntity="ApplicationForm")
     * @ORM\JoinColumn(name="gibbonApplicationFormID", referencedColumnName="gibbonApplicationFormID", nullable=false)
     */
    private $applicationForm;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $relationship;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ApplicationFormRelationship
     */
    public function setId(?int $id): ApplicationFormRelationship
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ApplicationForm|null
     */
    public function getApplicationForm(): ?ApplicationForm
    {
        return $this->applicationForm;
    }

    /**
     * @param ApplicationForm|null $applicationForm
     * @return ApplicationFormRelationship
     */
    public function setApplicationForm(?ApplicationForm $applicationForm): ApplicationFormRelationship
    {
        $this->applicationForm = $applicationForm;
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
     * @return ApplicationFormRelationship
     */
    public function setPerson(?Person $person): ApplicationFormRelationship
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    /**
     * @param string|null $relationship
     * @return ApplicationFormRelationship
     */
    public function setRelationship(?string $relationship): ApplicationFormRelationship
    {
        $this->relationship = $relationship;
        return $this;
    }
}