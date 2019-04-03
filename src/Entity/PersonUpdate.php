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
 * Class PersonUpdate
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PersonUpdateRepository")
 * @ORM\Table(name="PersonUpdate", indexes={@ORM\Index(name="gibbonPersonIndex", columns={"gibbonPersonID", "gibbonSchoolYearID"})})
 * @ORM\HasLifecycleCallbacks()
 */
class PersonUpdate
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonPersonUpdateID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=true)
     */
    private $schoolYear;

    /**
     * @var string|null
     * @ORM\Column(length=8, options={"default": "Pending"})
     */
    private $status = 'Pending';

    /**
     * @var array
     */
    private static $statusList = ['Pending', 'Complete'];

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=5)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(length=60)
     */
    private $surname;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="firstName")
     */
    private $firstName;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="preferredName")
     */
    private $preferredName;

    /**
     * @var string|null
     * @ORM\Column(length=150, name="officialName")
     */
    private $officialName;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="nameInCharacters")
     */
    private $nameInCharacters;

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
     * @ORM\Column(length=75, name="emailAlternate", nullable=true)
     */
    private $emailAlternate;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $address1;

    /**
     * @var string|null
     * @ORM\Column(length=255, name="address1District")
     */
    private $address1District;

    /**
     * @var string|null
     * @ORM\Column(length=255, name="address1Country")
     */
    private $address1Country;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $address2;

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $address2District;

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $address2Country;

    /**
     * @var string|null
     * @ORM\Column(length=6)
     */
    private $phone1Type = '';

    /**
     * @var string|null
     * @ORM\Column(length=7, name="phone1CountryCode")
     */
    private $phone1CountryCode;

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $phone1;

    /**
     * @var string|null
     * @ORM\Column(length=6)
     */
    private $phone2Type = '';

    /**
     * @var string|null
     * @ORM\Column(length=7, name="phone2CountryCode")
     */
    private $phone2CountryCode;

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $phone2;

    /**
     * @var string|null
     * @ORM\Column(length=6)
     */
    private $phone3Type = '';

    /**
     * @var string|null
     * @ORM\Column(length=7, name="phone3CountryCode")
     */
    private $phone3CountryCode;

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $phone3;

    /**
     * @var string|null
     * @ORM\Column(length=6)
     */
    private $phone4Type = '';
    /**
     * @var string|null
     * @ORM\Column(length=7, name="phone4CountryCode")
     */
    private $phone4CountryCode;

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $phone4;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="languageFirst")
     */
    private $languageFirst;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="languageSecond")
     */
    private $languageSecond;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="languageThird")
     */
    private $languageThird;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="countryOfBirth")
     */
    private $countryOfBirth;

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $ethnicity;

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $citizenship1;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $citizenship1Passport;

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $citizenship2;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $citizenship2Passport;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $religion;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="nationalIDCardCountry")
     */
    private $nationalIDCardCountry;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="nationalIDCardNumber")
     */
    private $nationalIDCardNumber;

    /**
     * @var string|null
     * @ORM\Column(length=255, name="residencyStatus")
     */
    private $residencyStatus;

    /**
     * @var \DateTime|null
     * @ORM\Column(nullable=true, type="date", name="visaExpiryDate")
     */
    private $visaExpiryDate;

    /**
     * @var string|null
     * @ORM\Column(length=90, nullable=true)
     */
    private $profession;

    /**
     * @var string|null
     * @ORM\Column(length=90, nullable=true)
     */
    private $employer;

    /**
     * @var string|null
     * @ORM\Column(length=90, name="jobTitle", nullable=true)
     */
    private $jobTitle;

    /**
     * @var string|null
     * @ORM\Column(length=90, nullable=true)
     */
    private $emergency1Name;

    /**
     * @var string|null
     * @ORM\Column(length=30, nullable=true)
     */
    private $emergency1Number1;

    /**
     * @var string|null
     * @ORM\Column(length=30, nullable=true)
     */
    private $emergency1Number2;

    /**
     * @var string|null
     * @ORM\Column(length=30, nullable=true)
     */
    private $emergency1Relationship;

    /**
     * @var string|null
     * @ORM\Column(length=90, nullable=true)
     */
    private $emergency2Name;

    /**
     * @var string|null
     * @ORM\Column(length=30, nullable=true)
     */
    private $emergency2Number1;

    /**
     * @var string|null
     * @ORM\Column(length=30, nullable=true)
     */
    private $emergency2Number2;

    /**
     * @var string|null
     * @ORM\Column(length=30, nullable=true)
     */
    private $emergency2Relationship;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="vehicleRegistration")
     */
    private $vehicleRegistration;

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
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $privacy;

    /**
     * @var string|null
     * @ORM\Column(type="text", options={"comment": "Serialised array of custom field values"})
     */
    private $fields;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PersonUpdate
     */
    public function setId(?int $id): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setSchoolYear(?SchoolYear $schoolYear): PersonUpdate
    {
        $this->schoolYear = $schoolYear;
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
     * @return PersonUpdate
     */
    public function setStatus(?string $status): PersonUpdate
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Pending' ;
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
     * @return PersonUpdate
     */
    public function setPerson(?Person $person): PersonUpdate
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return PersonUpdate
     */
    public function setTitle(?string $title): PersonUpdate
    {
        $this->title = $title;
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
     * @return PersonUpdate
     */
    public function setSurname(?string $surname): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setFirstName(?string $firstName): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setPreferredName(?string $preferredName): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setOfficialName(?string $officialName): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setNameInCharacters(?string $nameInCharacters): PersonUpdate
    {
        $this->nameInCharacters = $nameInCharacters;
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
     * @return PersonUpdate
     */
    public function setDob(?\DateTime $dob): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setEmail(?string $email): PersonUpdate
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailAlternate(): ?string
    {
        return $this->emailAlternate;
    }

    /**
     * @param string|null $emailAlternate
     * @return PersonUpdate
     */
    public function setEmailAlternate(?string $emailAlternate): PersonUpdate
    {
        $this->emailAlternate = $emailAlternate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    /**
     * @param string|null $address1
     * @return PersonUpdate
     */
    public function setAddress1(?string $address1): PersonUpdate
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress1District(): ?string
    {
        return $this->address1District;
    }

    /**
     * @param string|null $address1District
     * @return PersonUpdate
     */
    public function setAddress1District(?string $address1District): PersonUpdate
    {
        $this->address1District = $address1District;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress1Country(): ?string
    {
        return $this->address1Country;
    }

    /**
     * @param string|null $address1Country
     * @return PersonUpdate
     */
    public function setAddress1Country(?string $address1Country): PersonUpdate
    {
        $this->address1Country = $address1Country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * @param string|null $address2
     * @return PersonUpdate
     */
    public function setAddress2(?string $address2): PersonUpdate
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress2District(): ?string
    {
        return $this->address2District;
    }

    /**
     * @param string|null $address2District
     * @return PersonUpdate
     */
    public function setAddress2District(?string $address2District): PersonUpdate
    {
        $this->address2District = $address2District;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress2Country(): ?string
    {
        return $this->address2Country;
    }

    /**
     * @param string|null $address2Country
     * @return PersonUpdate
     */
    public function setAddress2Country(?string $address2Country): PersonUpdate
    {
        $this->address2Country = $address2Country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone1Type(): ?string
    {
        return $this->phone1Type;
    }

    /**
     * @param string|null $phone1Type
     * @return PersonUpdate
     */
    public function setPhone1Type(?string $phone1Type): PersonUpdate
    {
        $this->phone1Type = in_array($phone1Type, self::gePhoneTypeList()) ? $phone1Type : '' ;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone1CountryCode(): ?string
    {
        return $this->phone1CountryCode;
    }

    /**
     * @param string|null $phone1CountryCode
     * @return PersonUpdate
     */
    public function setPhone1CountryCode(?string $phone1CountryCode): PersonUpdate
    {
        $this->phone1CountryCode = $phone1CountryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone1(): ?string
    {
        return $this->phone1;
    }

    /**
     * @param string|null $phone1
     * @return PersonUpdate
     */
    public function setPhone1(?string $phone1): PersonUpdate
    {
        $this->phone1 = $phone1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone2Type(): ?string
    {
        return $this->phone2Type;
    }

    /**
     * @param string|null $phone2Type
     * @return PersonUpdate
     */
    public function setPhone2Type(?string $phone2Type): PersonUpdate
    {
        $this->phone2Type = in_array($phone2Type, self::gePhoneTypeList()) ? $phone2Type : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone2CountryCode(): ?string
    {
        return $this->phone2CountryCode;
    }

    /**
     * @param string|null $phone2CountryCode
     * @return PersonUpdate
     */
    public function setPhone2CountryCode(?string $phone2CountryCode): PersonUpdate
    {
        $this->phone2CountryCode = $phone2CountryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    /**
     * @param string|null $phone2
     * @return PersonUpdate
     */
    public function setPhone2(?string $phone2): PersonUpdate
    {
        $this->phone2 = $phone2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone3Type(): ?string
    {
        return $this->phone3Type;
    }

    /**
     * @param string|null $phone3Type
     * @return PersonUpdate
     */
    public function setPhone3Type(?string $phone3Type): PersonUpdate
    {
        $this->phone3Type = in_array($phone3Type, self::gePhoneTypeList()) ? $phone3Type : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone3CountryCode(): ?string
    {
        return $this->phone3CountryCode;
    }

    /**
     * @param string|null $phone3CountryCode
     * @return PersonUpdate
     */
    public function setPhone3CountryCode(?string $phone3CountryCode): PersonUpdate
    {
        $this->phone3CountryCode = $phone3CountryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone3(): ?string
    {
        return $this->phone3;
    }

    /**
     * @param string|null $phone3
     * @return PersonUpdate
     */
    public function setPhone3(?string $phone3): PersonUpdate
    {
        $this->phone3 = $phone3;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone4Type(): ?string
    {
        return $this->phone4Type;
    }

    /**
     * @param string|null $phone4Type
     * @return PersonUpdate
     */
    public function setPhone4Type(?string $phone4Type): PersonUpdate
    {
        $this->phone4Type = in_array($phone4Type, self::gePhoneTypeList()) ? $phone4Type : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone4CountryCode(): ?string
    {
        return $this->phone4CountryCode;
    }

    /**
     * @param string|null $phone4CountryCode
     * @return PersonUpdate
     */
    public function setPhone4CountryCode(?string $phone4CountryCode): PersonUpdate
    {
        $this->phone4CountryCode = $phone4CountryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone4(): ?string
    {
        return $this->phone4;
    }

    /**
     * @param string|null $phone4
     * @return PersonUpdate
     */
    public function setPhone4(?string $phone4): PersonUpdate
    {
        $this->phone4 = $phone4;
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
     * @return PersonUpdate
     */
    public function setLanguageFirst(?string $languageFirst): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setLanguageSecond(?string $languageSecond): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setLanguageThird(?string $languageThird): PersonUpdate
    {
        $this->languageThird = $languageThird;
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
     * @return PersonUpdate
     */
    public function setCountryOfBirth(?string $countryOfBirth): PersonUpdate
    {
        $this->countryOfBirth = $countryOfBirth;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEthnicity(): ?string
    {
        return $this->ethnicity;
    }

    /**
     * @param string|null $ethnicity
     * @return PersonUpdate
     */
    public function setEthnicity(?string $ethnicity): PersonUpdate
    {
        $this->ethnicity = $ethnicity;
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
     * @return PersonUpdate
     */
    public function setCitizenship1(?string $citizenship1): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setCitizenship1Passport(?string $citizenship1Passport): PersonUpdate
    {
        $this->citizenship1Passport = $citizenship1Passport;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCitizenship2(): ?string
    {
        return $this->citizenship2;
    }

    /**
     * @param string|null $citizenship2
     * @return PersonUpdate
     */
    public function setCitizenship2(?string $citizenship2): PersonUpdate
    {
        $this->citizenship2 = $citizenship2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCitizenship2Passport(): ?string
    {
        return $this->citizenship2Passport;
    }

    /**
     * @param string|null $citizenship2Passport
     * @return PersonUpdate
     */
    public function setCitizenship2Passport(?string $citizenship2Passport): PersonUpdate
    {
        $this->citizenship2Passport = $citizenship2Passport;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReligion(): ?string
    {
        return $this->religion;
    }

    /**
     * @param string|null $religion
     * @return PersonUpdate
     */
    public function setReligion(?string $religion): PersonUpdate
    {
        $this->religion = $religion;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNationalIDCardCountry(): ?string
    {
        return $this->nationalIDCardCountry;
    }

    /**
     * @param string|null $nationalIDCardCountry
     * @return PersonUpdate
     */
    public function setNationalIDCardCountry(?string $nationalIDCardCountry): PersonUpdate
    {
        $this->nationalIDCardCountry = $nationalIDCardCountry;
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
     * @return PersonUpdate
     */
    public function setNationalIDCardNumber(?string $nationalIDCardNumber): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setResidencyStatus(?string $residencyStatus): PersonUpdate
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
     * @return PersonUpdate
     */
    public function setVisaExpiryDate(?\DateTime $visaExpiryDate): PersonUpdate
    {
        $this->visaExpiryDate = $visaExpiryDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProfession(): ?string
    {
        return $this->profession;
    }

    /**
     * @param string|null $profession
     * @return PersonUpdate
     */
    public function setProfession(?string $profession): PersonUpdate
    {
        $this->profession = $profession;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmployer(): ?string
    {
        return $this->employer;
    }

    /**
     * @param string|null $employer
     * @return PersonUpdate
     */
    public function setEmployer(?string $employer): PersonUpdate
    {
        $this->employer = $employer;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    /**
     * @param string|null $jobTitle
     * @return PersonUpdate
     */
    public function setJobTitle(?string $jobTitle): PersonUpdate
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmergency1Name(): ?string
    {
        return $this->emergency1Name;
    }

    /**
     * @param string|null $emergency1Name
     * @return PersonUpdate
     */
    public function setEmergency1Name(?string $emergency1Name): PersonUpdate
    {
        $this->emergency1Name = $emergency1Name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmergency1Number1(): ?string
    {
        return $this->emergency1Number1;
    }

    /**
     * @param string|null $emergency1Number1
     * @return PersonUpdate
     */
    public function setEmergency1Number1(?string $emergency1Number1): PersonUpdate
    {
        $this->emergency1Number1 = $emergency1Number1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmergency1Number2(): ?string
    {
        return $this->emergency1Number2;
    }

    /**
     * @param string|null $emergency1Number2
     * @return PersonUpdate
     */
    public function setEmergency1Number2(?string $emergency1Number2): PersonUpdate
    {
        $this->emergency1Number2 = $emergency1Number2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmergency1Relationship(): ?string
    {
        return $this->emergency1Relationship;
    }

    /**
     * @param string|null $emergency1Relationship
     * @return PersonUpdate
     */
    public function setEmergency1Relationship(?string $emergency1Relationship): PersonUpdate
    {
        $this->emergency1Relationship = $emergency1Relationship;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmergency2Name(): ?string
    {
        return $this->emergency2Name;
    }

    /**
     * @param string|null $emergency2Name
     * @return PersonUpdate
     */
    public function setEmergency2Name(?string $emergency2Name): PersonUpdate
    {
        $this->emergency2Name = $emergency2Name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmergency2Number1(): ?string
    {
        return $this->emergency2Number1;
    }

    /**
     * @param string|null $emergency2Number1
     * @return PersonUpdate
     */
    public function setEmergency2Number1(?string $emergency2Number1): PersonUpdate
    {
        $this->emergency2Number1 = $emergency2Number1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmergency2Number2(): ?string
    {
        return $this->emergency2Number2;
    }

    /**
     * @param string|null $emergency2Number2
     * @return PersonUpdate
     */
    public function setEmergency2Number2(?string $emergency2Number2): PersonUpdate
    {
        $this->emergency2Number2 = $emergency2Number2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmergency2Relationship(): ?string
    {
        return $this->emergency2Relationship;
    }

    /**
     * @param string|null $emergency2Relationship
     * @return PersonUpdate
     */
    public function setEmergency2Relationship(?string $emergency2Relationship): PersonUpdate
    {
        $this->emergency2Relationship = $emergency2Relationship;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVehicleRegistration(): ?string
    {
        return $this->vehicleRegistration;
    }

    /**
     * @param string|null $vehicleRegistration
     * @return PersonUpdate
     */
    public function setVehicleRegistration(?string $vehicleRegistration): PersonUpdate
    {
        $this->vehicleRegistration = $vehicleRegistration;
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
     * @return PersonUpdate
     */
    public function setPersonUpdater(?Person $personUpdater): PersonUpdate
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
     * @return PersonUpdate
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestamp(?\DateTime $timestamp = null): PersonUpdate
    {
        $this->timestamp = $timestamp ?: new \DateTime('now');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrivacy(): ?string
    {
        return $this->privacy;
    }

    /**
     * @param string|null $privacy
     * @return PersonUpdate
     */
    public function setPrivacy(?string $privacy): PersonUpdate
    {
        $this->privacy = $privacy;
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
     * @return PersonUpdate
     */
    public function setFields(?string $fields): PersonUpdate
    {
        $this->fields = $fields;
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
    public static function gePhoneTypeList(): array
    {
        return Person::getPhoneTypeList();
    }
}