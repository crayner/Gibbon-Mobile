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
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 08:17
 */
namespace App\Entity;

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class GibbonPerson
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ORM\Table(name="Person")
 */
class Person
{
    use BooleanList;
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonPersonID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @return array
     */
    public static function getPhoneTypeList(): array
    {
        return self::$phoneTypeList;
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }

    /**
     * getGenderList
     *
     * @return array
     */
    public static function getGenderList(): array
    {
        return self::$genderList;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Person
     */
    public function setId(?int $id): Person
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=5)
     */
    private $title;

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     * @return Person
     */
    public function setTitle(?string $title): Person
    {
        $this->title = mb_substr($title, 0, 5);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=60)
     */
    private $surname;

    /**
     * @return null|string
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param null|string $surname
     * @return Person
     */
    public function setSurname(?string $surname): Person
    {
        $this->surname = mb_substr($surname, 0, 60);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=60)
     */
    private $firstName;

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param null|string $firstName
     * @return Person
     */
    public function setFirstName(?string $firstName): Person
    {
        $this->firstName = mb_substr($firstName, 0, 60);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=60)
     */
    private $preferredName;

    /**
     * @return null|string
     */
    public function getPreferredName(): ?string
    {
        return $this->preferredName;
    }

    /**
     * @param null|string $preferredName
     * @return Person
     */
    public function setPreferredName(?string $preferredName): Person
    {
        $this->preferredName = mb_substr($preferredName, 0, 60);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=150)
     */
    private $officialName;

    /**
     * @return null|string
     */
    public function getOfficialName(): ?string
    {
        return $this->officialName;
    }

    /**
     * @param null|string $officialName
     * @return Person
     */
    public function setOfficialName(?string $officialName): Person
    {
        $this->officialName = mb_substr($officialName, 0, 150);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=60)
     */
    private $nameInCharacters;

    /**
     * @return null|string
     */
    public function getNameInCharacters(): ?string
    {
        return $this->nameInCharacters;
    }

    /**
     * @param null|string $nameInCharacters
     * @return Person
     */
    public function setNameInCharacters(?string $nameInCharacters): Person
    {
        $this->nameInCharacters = mb_substr($nameInCharacters, 0, 60);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=16)
     */
    private $gender;

    /**
     * @var array
     */
    private static $genderList = [
        'M',
        'F',
        'Other',
        'Unspecified',
    ];

    /**
     * @return null|string
     */
    public function getGender(): ?string
    {
        return $this->gender = in_array($this->gender, self::getGenderList()) ? $this->gender : 'Unspecified';
    }

    /**
     * @param null|string $gender
     * @return Person
     */
    public function setGender(?string $gender): Person
    {
        $this->gender = in_array($gender, self::getGenderList()) ? $gender : 'Unspecified';
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $username;

    /**
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param null|string $username
     * @return Person
     */
    public function setUsername(?string $username): Person
    {
        $this->username = mb_substr($username, 0, 20);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $password;

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     * @return Person
     */
    public function setPassword(?string $password): Person
    {
        $this->password = mb_substr($password, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $passwordStrong;

    /**
     * @return null|string
     */
    public function getPasswordStrong(): ?string
    {
        return $this->passwordStrong;
    }

    /**
     * @param null|string $passwordStrong
     * @return Person
     */
    public function setPasswordStrong(?string $passwordStrong): Person
    {
        $this->passwordStrong = mb_substr($passwordStrong, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $passwordStrongSalt;

    /**
     * @return null|string
     */
    public function getPasswordStrongSalt(): ?string
    {
        return $this->passwordStrongSalt;
    }

    /**
     * @param null|string $passwordStrongSalt
     * @return Person
     */
    public function setPasswordStrongSalt(?string $passwordStrongSalt): Person
    {
        $this->passwordStrongSalt = mb_substr($passwordStrongSalt, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $passwordForceReset;

    /**
     * @return null|string
     */
    public function getPasswordForceReset(): ?string
    {
        return $this->passwordForceReset = in_array($this->passwordForceReset, self::getBooleanList()) ? $this->passwordForceReset : 'N' ;
    }

    /**
     * @param null|string $passwordForceReset
     * @return Person
     */
    public function setPasswordForceReset(?string $passwordForceReset): Person
    {
        $this->passwordForceReset = in_array($passwordForceReset, self::getBooleanList()) ? $passwordForceReset : 'N' ;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=16)
     */
    private $status;

    /**
     * @var array
     */
    private static $statusList = [
        'Full',
        'Expected',
        'Left',
        'Pending Approval',
    ];

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status = in_array($this->status, self::getStatusList()) ? $this->status : 'Full' ;
    }

    /**
     * @param null|string $status
     * @return Person
     */
    public function setStatus(?string $status): Person
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Full' ;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $canLogin;

    /**
     * @return null|string
     */
    public function getCanLogin(): ?string
    {
        return $this->canLogin = in_array($this->canLogin, self::getBooleanList()) ? $this->canLogin : 'N' ;
    }

    /**
     * @param null|string $canLogin
     * @return Person
     */
    public function setCanLogin(?string $canLogin): Person
    {
        $this->canLogin = in_array($canLogin, self::getBooleanList()) ? $canLogin : 'N' ;
        return $this;
    }

    /**
     * @var Role|null
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="gibbonRoleIDPrimary", referencedColumnName="gibbonRoleID")
     */
    private $primaryRole;

    /**
     * @return Role|null
     */
    public function getPrimaryRole(): ?Role
    {
        return $this->primaryRole;
    }

    /**
     * @param Role|null $primaryRole
     * @return Person
     */
    public function setPrimaryRole(?Role $primaryRole): Person
    {
        $this->primaryRole = $primaryRole;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(name="gibbonRoleIDAll", length=255)
     */
    private $allRoles;

    /**
     * @return null|string
     */
    public function getAllRoles(): ?string
    {
        return $this->allRoles;
    }

    /**
     * @param null|string $allRoles
     * @return Person
     */
    public function setAllRoles(?string $allRoles): Person
    {
        $this->allRoles = $allRoles;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $dob;

    /**
     * @return \DateTime|null
     */
    public function getDob(): ?\DateTime
    {
        return $this->dob;
    }

    /**
     * @param \DateTime|null $dob
     * @return Person
     */
    public function setDob(?\DateTime $dob): Person
    {
        $this->dob = $dob;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=75)
     */
    private $email;

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return Person
     */
    public function setEmail(?string $email): Person
    {
        $this->email = mb_substr($email, 0, 75);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=75)
     */
    private $emailAlternate;

    /**
     * @return null|string
     */
    public function getEmailAlternate(): ?string
    {
        return $this->emailAlternate;
    }

    /**
     * @param null|string $emailAlternate
     * @return Person
     */
    public function setEmailAlternate(?string $emailAlternate): Person
    {
        $this->emailAlternate = mb_substr($emailAlternate, 0, 75);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $image_240;

    /**
     * @return null|string
     */
    public function getImage_240(): ?string
    {
        return $this->image_240;
    }

    /**
     * @param null|string $image_240
     * @return Person
     */
    public function setImage_240(?string $image_240): Person
    {
        $this->image_240 = mb_substr($image_240, 0, 75);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=15)
     */
    private $lastIPAddress;

    /**
     * @return null|string
     */
    public function getLastIPAddress(): ?string
    {
        return $this->lastIPAddress;
    }

    /**
     * @param null|string $lastIPAddress
     * @return Person
     */
    public function setLastIPAddress(?string $lastIPAddress): Person
    {
        $this->lastIPAddress = mb_substr($lastIPAddress, 0, 15);
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastTimestamp;

    /**
     * @return \DateTime|null
     */
    public function getLastTimestamp(): ?\DateTime
    {
        return $this->lastTimestamp;
    }

    /**
     * @param \DateTime|null $lastTimestamp
     * @return Person
     */
    public function setLastTimestamp(?\DateTime $lastTimestamp): Person
    {
        $this->lastTimestamp = $lastTimestamp;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=15, nullable=true)
     */
    private $lastFailIPAddress;

    /**
     * @return null|string
     */
    public function getLastFailIPAddress(): ?string
    {
        return $this->lastFailIPAddress;
    }

    /**
     * @param null|string $lastFailIPAddress
     * @return Person
     */
    public function setLastFailIPAddress(?string $lastFailIPAddress): Person
    {
        $this->lastFailIPAddress = mb_substr($lastFailIPAddress, 0, 15);
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastFailTimestamp;

    /**
     * @return \DateTime|null
     */
    public function getLastFailTimestamp(): ?\DateTime
    {
        return $this->lastFailTimestamp;
    }

    /**
     * @param \DateTime|null $lastFailTimestamp
     * @return Person
     */
    public function setLastFailTimestamp(?\DateTime $lastFailTimestamp): Person
    {
        $this->lastFailTimestamp = $lastFailTimestamp;
        return $this;
    }

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", columnDefinition="INT(1)", nullable=true)
     */
    private $failCount;

    /**
     * @return int|null
     */
    public function getFailCount(): ?int
    {
        return $this->failCount;
    }

    /**
     * @param int|null $failCount
     * @return Person
     */
    public function setFailCount(?int $failCount): Person
    {
        $this->failCount = $failCount;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $address1;

    /**
     * @return null|string
     */
    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    /**
     * @param null|string $address1
     * @return Person
     */
    public function setAddress1(?string $address1): Person
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $address1District;

    /**
     * @return null|string
     */
    public function getAddress1District(): ?string
    {
        return $this->address1District;
    }

    /**
     * @param null|string $address1District
     * @return Person
     */
    public function setAddress1District(?string $address1District): Person
    {
        $this->address1District = mb_substr($address1District, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $address1Country;

    /**
     * @return null|string
     */
    public function getAddress1Country(): ?string
    {
        return $this->address1Country;
    }

    /**
     * @param null|string $address1Country
     * @return Person
     */
    public function setAddress1Country(?string $address1Country): Person
    {
        $this->address1Country = mb_substr($address1Country, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $address2;

    /**
     * @return null|string
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * @param null|string $address2
     * @return Person
     */
    public function setAddress2(?string $address2): Person
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $address2District;

    /**
     * @return null|string
     */
    public function getAddress2District(): ?string
    {
        return $this->address2District;
    }

    /**
     * @param null|string $address2District
     * @return Person
     */
    public function setAddress2District(?string $address2District): Person
    {
        $this->address2District = mb_substr($address2District, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $address2Country;

    /**
     * @return null|string
     */
    public function getAddress2Country(): ?string
    {
        return $this->address2Country;
    }

    /**
     * @param null|string $address2Country
     * @return Person
     */
    public function setAddress2Country(?string $address2Country): Person
    {
        $this->address2Country = mb_substr($address2Country, 0, 255);
        return $this;
    }

    /**
     * @var array
     */
    private static $phoneTypeList = ['','Mobile','Home','Work','Fax','Pager','Other'];

    /**
     * @var string|null
     * @ORM\Column(length=6)
     */
    private $phone1Type;

    /**
     * @return null|string
     */
    public function getPhone1Type(): ?string
    {
        return $this->phone1Type = in_array($this->phone1Type, self::getPhoneTypeList()) ? $this->phone1Type : '' ;
    }

    /**
     * @param null|string $phone1Type
     * @return Person
     */
    public function setPhone1Type(?string $phone1Type): Person
    {
        $this->phone1Type = in_array($phone1Type, self::getPhoneTypeList()) ? $phone1Type : '' ;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=7)
     */
    private $phone1CountryCode;

    /**
     * @return null|string
     */
    public function getPhone1CountryCode(): ?string
    {
        return $this->phone1CountryCode;
    }

    /**
     * @param null|string $phone1CountryCode
     * @return Person
     */
    public function setPhone1CountryCode(?string $phone1CountryCode): Person
    {
        $this->phone1CountryCode = mb_substr($phone1CountryCode, 0, 7);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $phone1;

    /**
     * @return null|string
     */
    public function getPhone1(): ?string
    {
        return $this->phone1;
    }

    /**
     * @param null|string $phone1
     * @return Person
     */
    public function setPhone1(?string $phone1): Person
    {
        $this->phone1 = mb_substr($phone1, 0, 20);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=6)
     */
    private $phone2Type;

    /**
     * @return null|string
     */
    public function getPhone2Type(): ?string
    {
        return $this->phone2Type = in_array($this->phone2Type, self::getPhoneTypeList()) ? $this->phone2Type : '' ;
    }

    /**
     * @param null|string $phone2Type
     * @return Person
     */
    public function setPhone2Type(?string $phone2Type): Person
    {
        $this->phone2Type = in_array($phone2Type, self::getPhoneTypeList()) ? $phone2Type : '' ;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=7)
     */
    private $phone2CountryCode;

    /**
     * @return null|string
     */
    public function getPhone2CountryCode(): ?string
    {
        return $this->phone2CountryCode;
    }

    /**
     * @param null|string $phone2CountryCode
     * @return Person
     */
    public function setPhone2CountryCode(?string $phone2CountryCode): Person
    {
        $this->phone2CountryCode = mb_substr($phone2CountryCode, 0, 7);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $phone2;

    /**
     * @return null|string
     */
    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    /**
     * @param null|string $phone2
     * @return Person
     */
    public function setPhone2(?string $phone2): Person
    {
        $this->phone2 = mb_substr($phone2, 0, 20);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=6)
     */
    private $phone3Type;

    /**
     * @return null|string
     */
    public function getPhone3Type(): ?string
    {
        return $this->phone3Type = in_array($this->phone3Type, self::getPhoneTypeList()) ? $this->phone3Type : '' ;
    }

    /**
     * @param null|string $phone3Type
     * @return Person
     */
    public function setPhone3Type(?string $phone3Type): Person
    {
        $this->phone3Type = in_array($phone3Type, self::getPhoneTypeList()) ? $phone3Type : '' ;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=7)
     */
    private $phone3CountryCode;

    /**
     * @return null|string
     */
    public function getPhone3CountryCode(): ?string
    {
        return $this->phone3CountryCode;
    }

    /**
     * @param null|string $phone3CountryCode
     * @return Person
     */
    public function setPhone3CountryCode(?string $phone3CountryCode): Person
    {
        $this->phone3CountryCode = mb_substr($phone3CountryCode, 0, 7);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $phone3;

    /**
     * @return null|string
     */
    public function getPhone3(): ?string
    {
        return $this->phone3;
    }

    /**
     * @param null|string $phone3
     * @return Person
     */
    public function setPhone3(?string $phone3): Person
    {
        $this->phone3 = mb_substr($phone3, 0, 20);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=6)
     */
    private $phone4Type;

    /**
     * @return null|string
     */
    public function getPhone4Type(): ?string
    {
        return $this->phone4Type = in_array($this->phone4Type, self::getPhoneTypeList()) ? $this->phone4Type : '' ;
    }

    /**
     * @param null|string $phone4Type
     * @return Person
     */
    public function setPhone4Type(?string $phone4Type): Person
    {
        $this->phone4Type = in_array($phone4Type, self::getPhoneTypeList()) ? $phone4Type : '' ;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=7)
     */
    private $phone4CountryCode;

    /**
     * @return null|string
     */
    public function getPhone4CountryCode(): ?string
    {
        return $this->phone4CountryCode;
    }

    /**
     * @param null|string $phone4CountryCode
     * @return Person
     */
    public function setPhone4CountryCode(?string $phone4CountryCode): Person
    {
        $this->phone4CountryCode = mb_substr($phone4CountryCode, 0, 7);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $phone4;

    /**
     * @return null|string
     */
    public function getPhone4(): ?string
    {
        return $this->phone4;
    }

    /**
     * @param null|string $phone4
     * @return Person
     */
    public function setPhone4(?string $phone4): Person
    {
        $this->phone4 = mb_substr($phone4, 0, 20);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $website;

    /**
     * @return null|string
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param null|string $website
     * @return Person
     */
    public function setWebsite(?string $website): Person
    {
        $this->website = mb_substr($website, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $languageFirst;

    /**
     * @return null|string
     */
    public function getLanguageFirst(): ?string
    {
        return $this->languageFirst;
    }

    /**
     * @param null|string $languageFirst
     * @return Person
     */
    public function setLanguageFirst(?string $languageFirst): Person
    {
        $this->languageFirst = mb_substr($languageFirst, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $languageSecond;

    /**
     * @return null|string
     */
    public function getLanguageSecond(): ?string
    {
        return $this->languageSecond;
    }

    /**
     * @param null|string $languageSecond
     * @return Person
     */
    public function setLanguageSecond(?string $languageSecond): Person
    {
        $this->languageSecond = mb_substr($languageSecond, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $languageThird;

    /**
     * @return null|string
     */
    public function getLanguageThird(): ?string
    {
        return $this->languageThird;
    }

    /**
     * @param null|string $languageThird
     * @return Person
     */
    public function setLanguageThird(?string $languageThird): Person
    {
        $this->languageThird = mb_substr($languageThird, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $countryOfBirth;

    /**
     * @return null|string
     */
    public function getCountryOfBirth(): ?string
    {
        return $this->countryOfBirth;
    }

    /**
     * @param null|string $countryOfBirth
     * @return Person
     */
    public function setCountryOfBirth(?string $countryOfBirth): Person
    {
        $this->countryOfBirth = mb_substr($countryOfBirth, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $birthCertificateScan;

    /**
     * @return null|string
     */
    public function getBirthCertificateScan(): ?string
    {
        return $this->birthCertificateScan;
    }

    /**
     * @param null|string $birthCertificateScan
     * @return Person
     */
    public function setBirthCertificateScan(?string $birthCertificateScan): Person
    {
        $this->birthCertificateScan = mb_substr($birthCertificateScan, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $ethnicity;

    /**
     * @return null|string
     */
    public function getEthnicity(): ?string
    {
        return $this->ethnicity;
    }

    /**
     * @param null|string $ethnicity
     * @return Person
     */
    public function setEthnicity(?string $ethnicity): Person
    {
        $this->ethnicity = mb_substr($ethnicity, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $citizenship1;

    /**
     * @return null|string
     */
    public function getCitizenship1(): ?string
    {
        return $this->citizenship1;
    }

    /**
     * @param null|string $citizenship1
     * @return Person
     */
    public function setCitizenship1(?string $citizenship1): Person
    {
        $this->citizenship1 = mb_substr($citizenship1, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $citizenship1Passport;

    /**
     * @return null|string
     */
    public function getCitizenship1Passport(): ?string
    {
        return $this->citizenship1Passport;
    }

    /**
     * @param null|string $citizenship1Passport
     * @return Person
     */
    public function setCitizenship1Passport(?string $citizenship1Passport): Person
    {
        $this->citizenship1Passport = mb_substr($citizenship1Passport, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $citizenship1PassportScan;

    /**
     * @return null|string
     */
    public function getCitizenship1PassportScan(): ?string
    {
        return $this->citizenship1PassportScan;
    }

    /**
     * @param null|string $citizenship1PassportScan
     * @return Person
     */
    public function setCitizenship1PassportScan(?string $citizenship1PassportScan): Person
    {
        $this->citizenship1PassportScan = mb_substr($citizenship1PassportScan, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $citizenship2;

    /**
     * @return null|string
     */
    public function getCitizenship2(): ?string
    {
        return $this->citizenship2;
    }

    /**
     * @param null|string $citizenship2
     * @return Person
     */
    public function setCitizenship2(?string $citizenship2): Person
    {
        $this->citizenship2 = mb_substr($citizenship2, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $citizenship2Passport;

    /**
     * @return null|string
     */
    public function getCitizenship2Passport(): ?string
    {
        return $this->citizenship2Passport;
    }

    /**
     * @param null|string $citizenship2Passport
     * @return Person
     */
    public function setCitizenship2Passport(?string $citizenship2Passport): Person
    {
        $this->citizenship2Passport = mb_substr($citizenship2Passport, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $religion;

    /**
     * @return null|string
     */
    public function getReligion(): ?string
    {
        return $this->religion;
    }

    /**
     * @param null|string $religion
     * @return Person
     */
    public function setReligion(?string $religion): Person
    {
        $this->religion = mb_substr($religion, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $nationalIDCardNumber;

    /**
     * @return null|string
     */
    public function getNationalIDCardNumber(): ?string
    {
        return $this->nationalIDCardNumber;
    }

    /**
     * @param null|string $nationalIDCardNumber
     * @return Person
     */
    public function setNationalIDCardNumber(?string $nationalIDCardNumber): Person
    {
        $this->nationalIDCardNumber = mb_substr($nationalIDCardNumber, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $nationalIDCardScan;

    /**
     * @return null|string
     */
    public function getNationalIDCardScan(): ?string
    {
        return $this->nationalIDCardScan;
    }

    /**
     * @param null|string $nationalIDCardScan
     * @return Person
     */
    public function setNationalIDCardScan(?string $nationalIDCardScan): Person
    {
        $this->nationalIDCardScan = mb_substr($nationalIDCardScan, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $residencyStatus;

    /**
     * @return null|string
     */
    public function getResidencyStatus(): ?string
    {
        return $this->residencyStatus;
    }

    /**
     * @param null|string $residencyStatus
     * @return Person
     */
    public function setResidencyStatus(?string $residencyStatus): Person
    {
        $this->residencyStatus = mb_substr($residencyStatus, 0, 255);
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(nullable=true, type="date")
     */
    private $visaExpiryDate;

    /**
     * @return \DateTime|null
     */
    public function getVisaExpiryDate(): ?\DateTime
    {
        return $this->visaExpiryDate;
    }

    /**
     * @param \DateTime|null $visaExpiryDate
     * @return Person
     */
    public function setVisaExpiryDate(?\DateTime $visaExpiryDate): Person
    {
        $this->visaExpiryDate = $visaExpiryDate;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=90)
     */
    private $profession;

    /**
     * @return null|string
     */
    public function getProfession(): ?string
    {
        return $this->profession;
    }

    /**
     * @param null|string $profession
     * @return Person
     */
    public function setProfession(?string $profession): Person
    {
        $this->profession = mb_substr($profession, 0, 90);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=90)
     */
    private $employer;

    /**
     * @return null|string
     */
    public function getEmployer(): ?string
    {
        return $this->employer;
    }

    /**
     * @param null|string $employer
     * @return Person
     */
    public function setEmployer(?string $employer): Person
    {
        $this->employer = mb_substr($employer, 0, 90);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=90)
     */
    private $jobTitle;

    /**
     * @return null|string
     */
    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    /**
     * @param null|string $jobTitle
     * @return Person
     */
    public function setJobTitle(?string $jobTitle): Person
    {
        $this->jobTitle = mb_substr($jobTitle, 0, 90);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=90)
     */
    private $emergency1Name;

    /**
     * @return null|string
     */
    public function getEmergency1Name(): ?string
    {
        return $this->emergency1Name;
    }

    /**
     * @param null|string $emergency1Name
     * @return Person
     */
    public function setEmergency1Name(?string $emergency1Name): Person
    {
        $this->emergency1Name = mb_substr($emergency1Name, 0, 90);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $emergency1Number1;

    /**
     * @return null|string
     */
    public function getEmergency1Number1(): ?string
    {
        return $this->emergency1Number1;
    }

    /**
     * @param null|string $emergency1Number1
     * @return Person
     */
    public function setEmergency1Number1(?string $emergency1Number1): Person
    {
        $this->emergency1Number1 = mb_substr($emergency1Number1, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $emergency1Number2;

    /**
     * @return null|string
     */
    public function getEmergency1Number2(): ?string
    {
        return $this->emergency1Number2;
    }

    /**
     * @param null|string $emergency1Number2
     * @return Person
     */
    public function setEmergency1Number2(?string $emergency1Number2): Person
    {
        $this->emergency1Number2 = mb_substr($emergency1Number2, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $emergency1Relationship;

    /**
     * @return null|string
     */
    public function getEmergency1Relationship(): ?string
    {
        return $this->emergency1Relationship;
    }

    /**
     * @param null|string $emergency1Relationship
     * @return Person
     */
    public function setEmergency1Relationship(?string $emergency1Relationship): Person
    {
        $this->emergency1Relationship = mb_substr($emergency1Relationship, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=90)
     */
    private $emergency2Name;

    /**
     * @return null|string
     */
    public function getEmergency2Name(): ?string
    {
        return $this->emergency2Name;
    }

    /**
     * @param null|string $emergency2Name
     * @return Person
     */
    public function setEmergency2Name(?string $emergency2Name): Person
    {
        $this->emergency2Name = mb_substr($emergency2Name, 0, 90);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $emergency2Number1;

    /**
     * @return null|string
     */
    public function getEmergency2Number1(): ?string
    {
        return $this->emergency2Number1;
    }

    /**
     * @param null|string $emergency2Number1
     * @return Person
     */
    public function setEmergency2Number1(?string $emergency2Number1): Person
    {
        $this->emergency2Number1 = mb_substr($emergency2Number1, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $emergency2Number2;

    /**
     * @return null|string
     */
    public function getEmergency2Number2(): ?string
    {
        return $this->emergency2Number2;
    }

    /**
     * @param null|string $emergency2Number2
     * @return Person
     */
    public function setEmergency2Number2(?string $emergency2Number2): Person
    {
        $this->emergency2Number2 = mb_substr($emergency2Number2, 0, 30);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $emergency2Relationship;

    /**
     * @return null|string
     */
    public function getEmergency2Relationship(): ?string
    {
        return $this->emergency2Relationship;
    }

    /**
     * @param null|string $emergency2Relationship
     * @return Person
     */
    public function setEmergency2Relationship(?string $emergency2Relationship): Person
    {
        $this->emergency2Relationship = mb_substr($emergency2Relationship, 0, 30);
        return $this;
    }

    /**
     * @var House|null
     * @ORM\ManyToOne(targetEntity="House")
     * @ORM\JoinColumn(nullable=true, name="gibbonHouseID", referencedColumnName="gibbonHouseID")
     */
    private $house;

    /**
     * @return House|null
     */
    public function getHouse(): ?House
    {
        return $this->house;
    }

    /**
     * @param House|null $house
     * @return Person
     */
    public function setHouse(?House $house): Person
    {
        $this->house = $house;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=10)
     */
    private $studentID;

    /**
     * @return null|string
     */
    public function getStudentID(): ?string
    {
        return $this->studentID;
    }

    /**
     * @param null|string $studentID
     * @return Person
     */
    public function setStudentID(?string $studentID): Person
    {
        $this->studentID = mb_substr($studentID, 0, 10);
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $dateStart;

    /**
     * @return \DateTime|null
     */
    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime|null $dateStart
     * @return Person
     */
    public function setDateStart(?\DateTime $dateStart): Person
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $dateEnd;

    /**
     * @return \DateTime|null
     */
    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime|null $dateEnd
     * @return Person
     */
    public function setDateEnd(?\DateTime $dateEnd): Person
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(nullable=true, name="gibbonSchoolYearIDClassOf", referencedColumnName="gibbonSchoolYearID")
     */
    private $schoolYearClassOf;

    /**
     * @return SchoolYear|null
     */
    public function getSchoolYearClassOf(): ?SchoolYear
    {
        return $this->schoolYearClassOf;
    }

    /**
     * @param SchoolYear|null $schoolYearClassOf
     * @return Person
     */
    public function setSchoolYearClassOf(?SchoolYear $schoolYearClassOf): Person
    {
        $this->schoolYearClassOf = $schoolYearClassOf;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $lastSchool;

    /**
     * @return null|string
     */
    public function getLastSchool(): ?string
    {
        return $this->lastSchool;
    }

    /**
     * @param null|string $lastSchool
     * @return Person
     */
    public function setLastSchool(?string $lastSchool): Person
    {
        $this->lastSchool = mb_substr($lastSchool, 0, 100);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $nextSchool;

    /**
     * @return null|string
     */
    public function getNextSchool(): ?string
    {
        return $this->nextSchool;
    }

    /**
     * @param null|string $nextSchool
     * @return Person
     */
    public function setNextSchool(?string $nextSchool): Person
    {
        $this->nextSchool = mb_substr($nextSchool, 0, 100);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $departureReason;

    /**
     * @return null|string
     */
    public function getDepartureReason(): ?string
    {
        return $this->departureReason;
    }

    /**
     * @param null|string $departureReason
     * @return Person
     */
    public function setDepartureReason(?string $departureReason): Person
    {
        $this->departureReason = mb_substr($departureReason, 0, 50);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $transport;

    /**
     * @return null|string
     */
    public function getTransport(): ?string
    {
        return $this->transport;
    }

    /**
     * @param null|string $transport
     * @return Person
     */
    public function setTransport(?string $transport): Person
    {
        $this->transport = mb_substr($transport, 0, 50);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $transportNotes;

    /**
     * @return null|string
     */
    public function getTransportNotes(): ?string
    {
        return $this->transportNotes;
    }

    /**
     * @param null|string $transportNotes
     * @return Person
     */
    public function setTransportNotes(?string $transportNotes): Person
    {
        $this->transportNotes = $transportNotes;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $calendarFeedPersonal;

    /**
     * @return null|string
     */
    public function getCalendarFeedPersonal(): ?string
    {
        return $this->calendarFeedPersonal;
    }

    /**
     * @param null|string $calendarFeedPersonal
     * @return Person
     */
    public function setCalendarFeedPersonal(?string $calendarFeedPersonal): Person
    {
        $this->calendarFeedPersonal = $calendarFeedPersonal;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $viewCalendarSchool;

    /**
     * @return null|string
     */
    public function getViewCalendarSchool(): ?string
    {
        return $this->viewCalendarSchool;
    }

    /**
     * @param null|string $viewCalendarSchool
     * @return Person
     */
    public function setViewCalendarSchool(?string $viewCalendarSchool): Person
    {
        $this->viewCalendarSchool = in_array($viewCalendarSchool, self::getBooleanList()) ? $viewCalendarSchool : 'Y';
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $viewCalendarPersonal;

    /**
     * @return null|string
     */
    public function getViewCalendarPersonal(): ?string
    {
        return $this->viewCalendarPersonal;
    }

    /**
     * @param null|string $viewCalendarPersonal
     * @return Person
     */
    public function setViewCalendarPersonal(?string $viewCalendarPersonal): Person
    {
        $this->viewCalendarPersonal = in_array($viewCalendarPersonal, self::getBooleanList()) ? $viewCalendarPersonal : 'Y';
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $viewCalendarSpaceBooking;

    /**
     * @return null|string
     */
    public function getViewCalendarSpaceBooking(): ?string
    {
        return $this->viewCalendarSpaceBooking;
    }

    /**
     * @param null|string $viewCalendarSpaceBooking
     * @return Person
     */
    public function setViewCalendarSpaceBooking(?string $viewCalendarSpaceBooking): Person
    {
        $this->viewCalendarSpaceBooking = in_array($viewCalendarSpaceBooking, self::getBooleanList()) ? $viewCalendarSpaceBooking : 'N';
        return $this;
    }

    /**
     * @var ApplicationForm|null
     * @ORM\ManyToOne(targetEntity="ApplicationForm")
     * @ORM\JoinColumn(name="gibbonApplicationFormID", referencedColumnName="gibbonApplicationFormID", nullable=true)
     */
    private $applicationForm;

    /**
     * @return ApplicationForm|null
     */
    public function getApplicationForm(): ?ApplicationForm
    {
        return $this->applicationForm;
    }

    /**
     * @param ApplicationForm|null $applicationForm
     * @return Person
     */
    public function setApplicationForm(?ApplicationForm $applicationForm): Person
    {
        $this->applicationForm = $applicationForm;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $lockerNumber;

    /**
     * @return null|string
     */
    public function getLockerNumber(): ?string
    {
        return $this->lockerNumber;
    }

    /**
     * @param null|string $lockerNumber
     * @return Person
     */
    public function setLockerNumber(?string $lockerNumber): Person
    {
        $this->lockerNumber = mb_substr($lockerNumber, 0, 20);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $vehicleRegistration;

    /**
     * @return null|string
     */
    public function getVehicleRegistration(): ?string
    {
        return $this->vehicleRegistration;
    }

    /**
     * @param null|string $vehicleRegistration
     * @return Person
     */
    public function setVehicleRegistration(?string $vehicleRegistration): Person
    {
        $this->vehicleRegistration = mb_substr($vehicleRegistration, 0, 20);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $personalBackground;

    /**
     * @return null|string
     */
    public function getPersonalBackground(): ?string
    {
        return $this->personalBackground;
    }

    /**
     * @param null|string $personalBackground
     * @return Person
     */
    public function setPersonalBackground(?string $personalBackground): Person
    {
        $this->personalBackground = mb_substr($personalBackground, 0, 255);
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $messengerLastBubble;

    /**
     * @return \DateTime|null
     */
    public function getMessengerLastBubble(): ?\DateTime
    {
        return $this->messengerLastBubble;
    }

    /**
     * @param \DateTime|null $messengerLastBubble
     * @return Person
     */
    public function setMessengerLastBubble(?\DateTime $messengerLastBubble): Person
    {
        $this->messengerLastBubble = $messengerLastBubble;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $privacy;

    /**
     * @return null|string
     */
    public function getPrivacy(): ?string
    {
        return $this->privacy;
    }

    /**
     * @param null|string $privacy
     * @return Person
     */
    public function setPrivacy(?string $privacy): Person
    {
        $this->privacy = $privacy;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255, nullable=true)
     */
    private $dayType;

    /**
     * @return null|string
     */
    public function getDayType(): ?string
    {
        return $this->dayType;
    }

    /**
     * @param null|string $dayType
     * @return Person
     */
    public function setDayType(?string $dayType): Person
    {
        $this->dayType = mb_substr($dayType, 0, 255);
        return $this;
    }

    /**
     * @var Theme|null
     * @ORM\ManyToOne(targetEntity="Theme")
     * @ORM\JoinColumn(name="gibbonThemeIDPersonal", referencedColumnName="gibbonThemeID", nullable=true)
     */
    private $theme;

    /**
     * @return Theme|null
     */
    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    /**
     * @param Theme|null $theme
     * @return Person
     */
    public function setTheme(?Theme $theme): Person
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * @var I18n|null
     * @ORM\ManyToOne(targetEntity="I18n")
     * @ORM\JoinColumn(name="gibboni18nIDPersonal", referencedColumnName="gibboni18nID", nullable=true)
     */
    private $i18nPersonal;

    /**
     * @return I18n|null
     */
    public function getI18nPersonal(): ?I18n
    {
        return $this->i18nPersonal;
    }

    /**
     * @param I18n|null $i18nPersonal
     * @return Person
     */
    public function setI18nPersonal(?I18n $i18nPersonal): Person
    {
        $this->i18nPersonal = $i18nPersonal;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $studentAgreements;

    /**
     * @return null|string
     */
    public function getStudentAgreements(): ?string
    {
        return $this->studentAgreements;
    }

    /**
     * @param null|string $studentAgreements
     * @return Person
     */
    public function setStudentAgreements(?string $studentAgreements): Person
    {
        $this->studentAgreements = $studentAgreements;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $googleAPIRefreshToken;

    /**
     * @return null|string
     */
    public function getGoogleAPIRefreshToken(): ?string
    {
        return $this->googleAPIRefreshToken;
    }

    /**
     * @param null|string $googleAPIRefreshToken
     * @return Person
     */
    public function setGoogleAPIRefreshToken(?string $googleAPIRefreshToken): Person
    {
        $this->googleAPIRefreshToken = mb_substr($googleAPIRefreshToken, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $receiveNotificationEmails;

    /**
     * @return null|string
     */
    public function getReceiveNotificationEmails(): ?string
    {
        return $this->receiveNotificationEmails;
    }

    /**
     * @param null|string $receiveNotificationEmails
     * @return Person
     */
    public function setReceiveNotificationEmails(?string $receiveNotificationEmails): Person
    {
        $this->receiveNotificationEmails = in_array($receiveNotificationEmails, self::getBooleanList()) ? $receiveNotificationEmails : 'Y';
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $fields;

    /**
     * @return null|string
     */
    public function getFields(): ?string
    {
        return $this->fields;
    }

    /**
     * @param null|string $fields
     * @return Person
     */
    public function setFields(?string $fields): Person
    {
        $this->fields = $fields;
        return $this;
    }
}