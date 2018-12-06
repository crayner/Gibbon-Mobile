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
 * Class PersonMedical
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PersonMedicalRepository")
 * @ORM\Table(name="PersonMedical", indexes={@ORM\Index(name="gibbonPersonID", columns={"gibbonPersonID"})})
 */
class PersonMedical
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonPersonMedicalID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string
     * @ORM\Column(length=3, name="bloodType")
     */
    private $bloodType = '';

    /**
     * @var array
     */
    private static $bloodTypeList = ['','O+','A+','B+','AB+','O-','A-','B-','AB-'];

    /**
     * @var string|null
     * @ORM\Column(length=1, name="longTermMedication")
     */
    private $longTermMedication;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="longTermMedicationDetails")
     */
    private $longTermMedicationDetails;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="tetanusWithin10Years")
     */
    private $tetanusWithin10Years;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PersonMedical
     */
    public function setId(?int $id): PersonMedical
    {
        $this->id = $id;
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
     * @return PersonMedical
     */
    public function setPerson(?Person $person): PersonMedical
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string
     */
    public function getBloodType(): string
    {
        return $this->bloodType;
    }

    /**
     * @param string $bloodType
     * @return PersonMedical
     */
    public function setBloodType(string $bloodType): PersonMedical
    {
        $this->bloodType = in_array($bloodType, self::getBloodTypeList()) ? $bloodType : '' ;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongTermMedication(): ?string
    {
        return $this->longTermMedication;
    }

    /**
     * @param string|null $longTermMedication
     * @return PersonMedical
     */
    public function setLongTermMedication(?string $longTermMedication): PersonMedical
    {
        $this->longTermMedication = self::checkBoolean($longTermMedication, '');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongTermMedicationDetails(): ?string
    {
        return $this->longTermMedicationDetails;
    }

    /**
     * @param string|null $longTermMedicationDetails
     * @return PersonMedical
     */
    public function setLongTermMedicationDetails(?string $longTermMedicationDetails): PersonMedical
    {
        $this->longTermMedicationDetails = $longTermMedicationDetails;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTetanusWithin10Years(): ?string
    {
        return $this->tetanusWithin10Years;
    }

    /**
     * @param string|null $tetanusWithin10Years
     * @return PersonMedical
     */
    public function setTetanusWithin10Years(?string $tetanusWithin10Years): PersonMedical
    {
        $this->tetanusWithin10Years = self::checkBoolean($tetanusWithin10Years, '');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return PersonMedical
     */
    public function setComment(?string $comment): PersonMedical
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return array
     */
    public static function getBloodTypeList(): array
    {
        return self::$bloodTypeList;
    }
}