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

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class StaffApplicationForm
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StaffApplicationFormRepository")
 * @ORM\Table(name="StaffApplicationForm")
 */
class StaffApplicationForm
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonStaffApplicationFormID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var StaffJobOpening|null
     * @ORM\ManyToOne(targetEntity="StaffJobOpening")
     * @ORM\JoinColumn(name="gibbonStaffJobOpeningID", referencedColumnName="gibbonStaffJobOpeningID", nullable=false)
     */
    private $staffJobOpening;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=60, nullable=true)
     */
    private $surname;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="firstName", nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="preferredName", nullable=true)
     */
    private $preferredName;

    /**
     * @var string|null
     * @ORM\Column(length=150, name="officialName", nullable=true)
     */
    private $officialName;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="nameInCharacters", nullable=true)
     */
    private $nameInCharacters;

    /**
     * @var string|null
     * @ORM\Column(length=12, nullable=true)
     */
    private $gender = 'Unspecified';

    /**
     * @var string|null
     * @ORM\Column(length=12, options={"default": "Pending"})
     */
    private $status = 'Pending';

    /**
     * @var array
     */
    private static $statusList = ['Pending','Accepted','Rejected','Withdrawn'];

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string|null
     * @ORM\Column(length=75, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="homeAddress", nullable=true)
     */
    private $homeAddress;

    /**
     * @var string|null
     * @ORM\Column(name="homeAddressDistrict", nullable=true)
     */
    private $homeAddressDistrict;

    /**
     * @var string|null
     * @ORM\Column(name="homeAddressCountry", nullable=true)
     */
    private $homeAddressCountry;

    /**
     * @var string
     * @ORM\Column(length=6, name="phone1Type", nullable=true)
     */
    private $phone1Type = '';

    /**
     * @var string
     * @ORM\Column(length=7, name="phone1CountryCode", nullable=true)
     */
    private $phone1CountryCode;

    /**
     * @var string
     * @ORM\Column(length=20, nullable=true)
     */
    private $phone1;

    /**
     * @var string|null
     * @ORM\Column(length=30,name="countryOfBirth", nullable=true)
     */
    private $countryOfBirth;

    /**
     * @var string|null
     * @ORM\Column(name="citizenship1", nullable=true)
     */
    private $citizenship1;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="citizenship1Passport", nullable=true)
     */
    private $citizenship1Passport;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="nationalIDCardNumber", nullable=true)
     */
    private $nationalIDCardNumber;

    /**
     * @var string|null
     * @ORM\Column(length=255, name="residencyStatus", nullable=true)
     */
    private $residencyStatus;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="visaExpiryDate",nullable=true)
     */
    private $visaExpiryDate;

    /**
     * @var string|null
     * @ORM\Column(name="languageFirst", length=30, nullable=true)
     */
    private $languageFirst;

    /**
     * @var string|null
     * @ORM\Column(name="languageSecond", length=30, nullable=true)
     */
    private $languageSecond;

    /**
     * @var string|null
     * @ORM\Column(name="languageThird", length=30, nullable=true)
     */
    private $languageThird;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="agreement", nullable=true)
     */
    private $agreement;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestamp", nullable=true)
     */
    private $timestamp;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="priority", columnDefinition="INT(1)", options={"default": "0"})
     */
    private $priority = 0;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $milestones;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $notes;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="dateStart", nullable=true)
     */
    private $dateStart;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $questions;

    /**
     * @var string|null
     * @ORM\Column(type="text", options={"comment": "Serialised array of custom field values"})
     */
    private $fields;

    /**
     * @var string|null
     * @ORM\Column(name="referenceEmail1", length=100)
     */
    private $referenceEmail1;

    /**
     * @var string|null
     * @ORM\Column(name="referenceEmail2", length=100)
     */
    private $referenceEmail2;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return StaffApplicationForm
     */
    public function setId(?int $id): StaffApplicationForm
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return StaffJobOpening|null
     */
    public function getStaffJobOpening(): ?StaffJobOpening
    {
        return $this->staffJobOpening;
    }

    /**
     * @param StaffJobOpening|null $staffJobOpening
     * @return StaffApplicationForm
     */
    public function setStaffJobOpening(?StaffJobOpening $staffJobOpening): StaffApplicationForm
    {
        $this->staffJobOpening = $staffJobOpening;
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
     * @return StaffApplicationForm
     */
    public function setPerson(?Person $person): StaffApplicationForm
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     * @return StaffApplicationForm
     */
    public function setSurname(?string $surname): StaffApplicationForm
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return StaffApplicationForm
     */
    public function setFirstName(?string $firstName): StaffApplicationForm
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPreferredName(): ?string
    {
        return $this->preferredName;
    }

    /**
     * @param string|null $preferredName
     * @return StaffApplicationForm
     */
    public function setPreferredName(?string $preferredName): StaffApplicationForm
    {
        $this->preferredName = $preferredName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOfficialName(): ?string
    {
        return $this->officialName;
    }

    /**
     * @param string|null $officialName
     * @return StaffApplicationForm
     */
    public function setOfficialName(?string $officialName): StaffApplicationForm
    {
        $this->officialName = $officialName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameInCharacters(): ?string
    {
        return $this->nameInCharacters;
    }

    /**
     * @param string|null $nameInCharacters
     * @return StaffApplicationForm
     */
    public function setNameInCharacters(?string $nameInCharacters): StaffApplicationForm
    {
        $this->nameInCharacters = $nameInCharacters;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     * @return StaffApplicationForm
     */
    public function setGender(?string $gender): StaffApplicationForm
    {
        $this->gender = in_array($gender, self::getGenderList()) ? $gender : 'Unspecified' ;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return StaffApplicationForm
     */
    public function setStatus(?string $status): StaffApplicationForm
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Pending';
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDob(): ?\DateTime
    {
        return $this->dob;
    }

    /**
     * @param \DateTime|null $dob
     * @return StaffApplicationForm
     */
    public function setDob(?\DateTime $dob): StaffApplicationForm
    {
        $this->dob = $dob;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return StaffApplicationForm
     */
    public function setEmail(?string $email): StaffApplicationForm
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeAddress(): ?string
    {
        return $this->homeAddress;
    }

    /**
     * @param string|null $homeAddress
     * @return StaffApplicationForm
     */
    public function setHomeAddress(?string $homeAddress): StaffApplicationForm
    {
        $this->homeAddress = $homeAddress;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeAddressDistrict(): ?string
    {
        return $this->homeAddressDistrict;
    }

    /**
     * @param string|null $homeAddressDistrict
     * @return StaffApplicationForm
     */
    public function setHomeAddressDistrict(?string $homeAddressDistrict): StaffApplicationForm
    {
        $this->homeAddressDistrict = $homeAddressDistrict;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeAddressCountry(): ?string
    {
        return $this->homeAddressCountry;
    }

    /**
     * @param string|null $homeAddressCountry
     * @return StaffApplicationForm
     */
    public function setHomeAddressCountry(?string $homeAddressCountry): StaffApplicationForm
    {
        $this->homeAddressCountry = $homeAddressCountry;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone1Type(): string
    {
        return $this->phone1Type;
    }

    /**
     * @param string $phone1Type
     * @return StaffApplicationForm
     */
    public function setPhone1Type(string $phone1Type): StaffApplicationForm
    {
        $this->phone1Type = in_array($phone1Type, self::getPhoneTypeList()) ? $phone1Type : '';
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone1CountryCode(): string
    {
        return $this->phone1CountryCode;
    }

    /**
     * @param string $phone1CountryCode
     * @return StaffApplicationForm
     */
    public function setPhone1CountryCode(string $phone1CountryCode): StaffApplicationForm
    {
        $this->phone1CountryCode = $phone1CountryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone1(): string
    {
        return $this->phone1;
    }

    /**
     * @param string $phone1
     * @return StaffApplicationForm
     */
    public function setPhone1(string $phone1): StaffApplicationForm
    {
        $this->phone1 = $phone1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryOfBirth(): ?string
    {
        return $this->countryOfBirth;
    }

    /**
     * @param string|null $countryOfBirth
     * @return StaffApplicationForm
     */
    public function setCountryOfBirth(?string $countryOfBirth): StaffApplicationForm
    {
        $this->countryOfBirth = $countryOfBirth;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCitizenship1(): ?string
    {
        return $this->citizenship1;
    }

    /**
     * @param string|null $citizenship1
     * @return StaffApplicationForm
     */
    public function setCitizenship1(?string $citizenship1): StaffApplicationForm
    {
        $this->citizenship1 = $citizenship1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCitizenship1Passport(): ?string
    {
        return $this->citizenship1Passport;
    }

    /**
     * @param string|null $citizenship1Passport
     * @return StaffApplicationForm
     */
    public function setCitizenship1Passport(?string $citizenship1Passport): StaffApplicationForm
    {
        $this->citizenship1Passport = $citizenship1Passport;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNationalIDCardNumber(): ?string
    {
        return $this->nationalIDCardNumber;
    }

    /**
     * @param string|null $nationalIDCardNumber
     * @return StaffApplicationForm
     */
    public function setNationalIDCardNumber(?string $nationalIDCardNumber): StaffApplicationForm
    {
        $this->nationalIDCardNumber = $nationalIDCardNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResidencyStatus(): ?string
    {
        return $this->residencyStatus;
    }

    /**
     * @param string|null $residencyStatus
     * @return StaffApplicationForm
     */
    public function setResidencyStatus(?string $residencyStatus): StaffApplicationForm
    {
        $this->residencyStatus = $residencyStatus;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getVisaExpiryDate(): ?\DateTime
    {
        return $this->visaExpiryDate;
    }

    /**
     * @param \DateTime|null $visaExpiryDate
     * @return StaffApplicationForm
     */
    public function setVisaExpiryDate(?\DateTime $visaExpiryDate): StaffApplicationForm
    {
        $this->visaExpiryDate = $visaExpiryDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguageFirst(): ?string
    {
        return $this->languageFirst;
    }

    /**
     * @param string|null $languageFirst
     * @return StaffApplicationForm
     */
    public function setLanguageFirst(?string $languageFirst): StaffApplicationForm
    {
        $this->languageFirst = $languageFirst;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguageSecond(): ?string
    {
        return $this->languageSecond;
    }

    /**
     * @param string|null $languageSecond
     * @return StaffApplicationForm
     */
    public function setLanguageSecond(?string $languageSecond): StaffApplicationForm
    {
        $this->languageSecond = $languageSecond;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguageThird(): ?string
    {
        return $this->languageThird;
    }

    /**
     * @param string|null $languageThird
     * @return StaffApplicationForm
     */
    public function setLanguageThird(?string $languageThird): StaffApplicationForm
    {
        $this->languageThird = $languageThird;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAgreement(): ?string
    {
        return $this->agreement;
    }

    /**
     * @param string|null $agreement
     * @return StaffApplicationForm
     */
    public function setAgreement(?string $agreement): StaffApplicationForm
    {
        $this->agreement = $agreement;
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
     * @param \DateTime|null $timestamp
     * @return StaffApplicationForm
     */
    public function setTimestamp(?\DateTime $timestamp): StaffApplicationForm
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int|null $priority
     * @return StaffApplicationForm
     */
    public function setPriority(?int $priority): StaffApplicationForm
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMilestones(): ?string
    {
        return $this->milestones;
    }

    /**
     * @param string|null $milestones
     * @return StaffApplicationForm
     */
    public function setMilestones(?string $milestones): StaffApplicationForm
    {
        $this->milestones = $milestones;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     * @return StaffApplicationForm
     */
    public function setNotes(?string $notes): StaffApplicationForm
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime|null $dateStart
     * @return StaffApplicationForm
     */
    public function setDateStart(?\DateTime $dateStart): StaffApplicationForm
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuestions(): ?string
    {
        return $this->questions;
    }

    /**
     * @param string|null $questions
     * @return StaffApplicationForm
     */
    public function setQuestions(?string $questions): StaffApplicationForm
    {
        $this->questions = $questions;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFields(): ?string
    {
        return $this->fields;
    }

    /**
     * @param string|null $fields
     * @return StaffApplicationForm
     */
    public function setFields(?string $fields): StaffApplicationForm
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReferenceEmail1(): ?string
    {
        return $this->referenceEmail1;
    }

    /**
     * @param string|null $referenceEmail1
     * @return StaffApplicationForm
     */
    public function setReferenceEmail1(?string $referenceEmail1): StaffApplicationForm
    {
        $this->referenceEmail1 = $referenceEmail1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReferenceEmail2(): ?string
    {
        return $this->referenceEmail2;
    }

    /**
     * @param string|null $referenceEmail2
     * @return StaffApplicationForm
     */
    public function setReferenceEmail2(?string $referenceEmail2): StaffApplicationForm
    {
        $this->referenceEmail2 = $referenceEmail2;
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
    public static function getPhoneTypeList(): array
    {
        return Person::getPhoneTypeList();
    }

    /**
     * @return array
     */
    public static function getGenderList(): array
    {
        return Person::getGenderList();
    }
}