<?php
/**
 * Created by PhpStorm.
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
 * Class PersonMedicalUpdate
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PersonMedicalUpdateRepository")
 * @ORM\Table(name="PersonMedicalUpdate", indexes={@ORM\Index(name="gibbonMedicalIndex", columns={"gibbonPersonID","gibbonPersonMedicalID","gibbonSchoolYearID"})})
 * @ORM\HasLifecycleCallbacks()
 */
class PersonMedicalUpdate
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonPersonMedicalUpdateID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
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
     * @var string
     * @ORM\Column(length=8, options={"default": "Pending"})
     */
    private $status = 'Pending';

    /**
     * @var array 
     */
    private static $statusList = ['Pending', 'Complete'];

    /**
     * @var PersonMedical|null
     * @ORM\ManyToOne(targetEntity="PersonMedical")
     * @ORM\JoinColumn(name="gibbonPersonMedicalID", referencedColumnName="gibbonPersonMedicalID")
     */
    private $personMedical;

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
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDUpdater", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personUpdater;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestamp;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PersonMedicalUpdate
     */
    public function setId(?int $id): PersonMedicalUpdate
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
     * @return PersonMedicalUpdate
     */
    public function setSchoolYear(?SchoolYear $schoolYear): PersonMedicalUpdate
    {
        $this->schoolYear = $schoolYear;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return PersonMedicalUpdate
     */
    public function setStatus(string $status): PersonMedicalUpdate
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Pending';
        return $this;
    }

    /**
     * @return PersonMedical|null
     */
    public function getPersonMedical(): ?PersonMedical
    {
        return $this->personMedical;
    }

    /**
     * @param PersonMedical|null $personMedicale
     * @return PersonMedicalUpdate
     */
    public function setPersonMedical(?PersonMedical $personMedical): PersonMedicalUpdate
    {
        $this->personMedical = $personMedical;
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
     * @return PersonMedicalUpdate
     */
    public function setPerson(?Person $person): PersonMedicalUpdate
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
     * @return PersonMedicalUpdate
     */
    public function setBloodType(string $bloodType): PersonMedicalUpdate
    {
        $this->bloodType = in_array($bloodType, self::getBloodTypeList()) ? $bloodType : '';
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
     * @return PersonMedicalUpdate
     */
    public function setLongTermMedication(?string $longTermMedication): PersonMedicalUpdate
    {
        $this->longTermMedication = $longTermMedication;
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
     * @return PersonMedicalUpdate
     */
    public function setLongTermMedicationDetails(?string $longTermMedicationDetails): PersonMedicalUpdate
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
     * @return PersonMedicalUpdate
     */
    public function setTetanusWithin10Years(?string $tetanusWithin10Years): PersonMedicalUpdate
    {
        $this->tetanusWithin10Years = $tetanusWithin10Years;
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
     * @return PersonMedicalUpdate
     */
    public function setComment(?string $comment): PersonMedicalUpdate
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonUpdater(): ?Person
    {
        return $this->personUpdater;
    }

    /**
     * @param Person|null $personUpdater
     * @return PersonMedicalUpdate
     */
    public function setPersonUpdater(?Person $personUpdater): PersonMedicalUpdate
    {
        $this->personUpdater = $personUpdater;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    /**
     * setTimestamp
     * @param \DateTime|null $timestamp
     * @return PersonMedicalUpdate
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestamp(?\DateTime $timestamp = null): PersonMedicalUpdate
    {
        $this->timestamp = $timestamp ?: new \DateTime('now');
        return $this;
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }

    /**
     * @return array
     */
    public static function getBloodTypeList(): array
    {
        return PersonMedical::getBloodTypeList();
    }
}