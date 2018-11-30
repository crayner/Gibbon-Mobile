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
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 11:39
 */
namespace App\Entity;

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ApplicationForm
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationFormRepository")
 * @ORM\Table(name="ApplicationForm")
 */
class ApplicationForm
{
    use BooleanList;
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonApplicationFormID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=40, nullable=true, name="gibbonApplicationFormHash")
     */
    private $applicationFormHash;

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
     * @ORM\Column(length=20, name="nameInCharacters")
     */
    private $nameInCharacters;

    /**
     * @var string|null
     * @ORM\Column(length=12)
     */
    private $gender = 'Unspecified';

    /**
     * getGenderList
     * @return array
     */
    private static function getGenderList(){
        return Person::getGenderList();
    }

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $username;

    /**
     * @var string|null
     * @ORM\Column(length=12)
     */
    private $status = 'Pending';

    /**
     * @var array
     */
    private static $statusList = ['Pending','Waiting List','Accepted','Rejected','Withdrawn'];

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $dob;

    /**
     * @var string|null
     * @ORM\Column(length=75)
     */
    private $email;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="homeAddress")
     */
    private $homeAddress;

    /**
     * @var string|null
     * @ORM\Column(name="homeAddressDistrict")
     */
    private $homeAddressDistrict;

    /**
     * @var string|null
     * @ORM\Column(name="homeAddressCountry")
     */
    private $homeAddressCountry;

    /**
     * @var array 
     */
    private static $phoneTypeList = ['','Mobile','Home','Work','Fax','Pager','Other'];

    /**
     * @var string
     * @ORM\Column(length=6, name="phone1Type")
     */
    private $phone1Type = '';

    /**
     * @var string
     * @ORM\Column(length=7, name="phone1CountryCode")
     */
    private $phone1CountryCode;

    /**
     * @var string
     * @ORM\Column(length=20)
     */
    private $phone1;

    /**
     * @var string
     * @ORM\Column(length=6, name="phone2Type")
     */
    private $phone2Type = '';

    /**
     * @var string
     * @ORM\Column(length=7, name="phone2CountryCode")
     */
    private $phone2CountryCode;

    /**
     * @var string
     * @ORM\Column(length=20)
     */
    private $phone2;

    /**
     * @var string|null
     * @ORM\Column(length=30,name="countryOfBirth")
     */
    private $countryOfBirth;

    /**
     * @var string|null
     * @ORM\Column(name="citizenship1")
     */
    private $citizenship1;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="citizenship1Passport")
     */
    private $citizenship1Passport;

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
     * @ORM\Column(type="date", name="visaExpiryDate",nullable=true)
     */
    private $visaExpiryDate;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearIDEntry",referencedColumnName="gibbonSchoolYearID")
     */
    private $schoolYearEntry;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="YearGroup")
     * @ORM\JoinColumn(name="gibbonYearGroupIDEntry",referencedColumnName="gibbonYearGroupID")
     */
    private $yearGroupEntry;

    /**
     * @var string|null
     * @ORM\Column(name="dayType", nullable=true)
     */
    private $dayType;

    /**
     * @var string|null
     * @ORM\Column(name="referenceEmail", nullable=true, length=100)
     */
    private $referenceEmail;

    /**
     * @var string|null
     * @ORM\Column(name="schoolName1", length=50)
     */
    private $schoolName1;

    /**
     * @var string|null
     * @ORM\Column(name="schoolAddress1")
     */
    private $schoolAddress1;

    /**
     * @var string|null
     * @ORM\Column(name="schoolGrades1", length=20)
     */
    private $schoolGrades1;

    /**
     * @var string|null
     * @ORM\Column(name="schoolLanguage1", length=50)
     */
    private $schoolLanguage1;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="schoolDate1", type="date")
     */
    private $schoolDate1;

    /**
     * @var string|null
     * @ORM\Column(name="schoolName2", length=50)
     */
    private $schoolName2;

    /**
     * @var string|null
     * @ORM\Column(name="schoolAddress2")
     */
    private $schoolAddress2;

    /**
     * @var string|null
     * @ORM\Column(name="schoolGrades2", length=20)
     */
    private $schoolGrades2;

    /**
     * @var string|null
     * @ORM\Column(name="schoolLanguage2", length=50)
     */
    private $schoolLanguage2;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="schoolDate2", type="date")
     */
    private $schoolDate2;

    /**
     * @var string|null
     * @ORM\Column(name="siblingName1", length=50)
     */
    private $siblingName1;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="siblingDOB1", type="date", nullable=true)
     */
    private $siblingDOB1;

    /**
     * @var string|null
     * @ORM\Column(name="siblingSchool1", length=50)
     */
    private $siblingSchool1;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="siblingSchoolJoiningDate1", type="date", nullable=true)
     */
    private $siblingSchoolJoiningDate1;

    /**
     * @var string|null
     * @ORM\Column(name="siblingName2", length=50)
     */
    private $siblingName2;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="siblingDOB2", type="date", nullable=true)
     */
    private $siblingDOB2;

    /**
     * @var string|null
     * @ORM\Column(name="siblingSchool2", length=50)
     */
    private $siblingSchool2;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="siblingSchoolJoiningDate2", type="date", nullable=true)
     */
    private $siblingSchoolJoiningDate2;

    /**
     * @var string|null
     * @ORM\Column(name="siblingName3", length=50)
     */
    private $siblingName3;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="siblingDOB3", type="date", nullable=true)
     */
    private $siblingDOB3;

    /**
     * @var string|null
     * @ORM\Column(name="siblingSchool3", length=50)
     */
    private $siblingSchool3;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="siblingSchoolJoiningDate3", type="date", nullable=true)
     */
    private $siblingSchoolJoiningDate3;

    /**
     * @var string|null
     * @ORM\Column(name="languageHomePrimary", length=30)
     */
    private $languageHomePrimary;

    /**
     * @var string|null
     * @ORM\Column(name="languageHomeSecondary", length=30)
     */
    private $languageHomeSecondary;

    /**
     * @var string|null
     * @ORM\Column(name="languageFirst", length=30)
     */
    private $languageFirst;

    /**
     * @var string|null
     * @ORM\Column(name="languageSecond", length=30)
     */
    private $languageSecond;

    /**
     * @var string|null
     * @ORM\Column(name="languageThird", length=30)
     */
    private $languageThird;

    /**
     * @var string|null
     * @ORM\Column(name="medicalInformation", type="text")
     */
    private $medicalInformation;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $sen;

    /**
     * @var string|null
     * @ORM\Column(name="senDetails", type="text")
     */
    private $senDetails;

    /**
     * @var string|null
     * @ORM\Column(name="languageChoice", length=100)
     */
    private $languageChoice;

    /**
     * @var string|null
     * @ORM\Column(name="languageChoiceExperience", type="text")
     */
    private $languageChoiceExperience;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="scholarshipInterest")
     */
    private $scholarshipInterest = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="scholarshipRequired")
     */
    private $scholarshipRequired = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=7)
     */
    private $payment = 'Family';

    /**
     * @var array
     */
    private static $paymentList = ['Family', 'Company'];

    /**
     * @var string|null
     * @ORM\Column(name="companyName", length=100)
     */
    private $companyName;

    /**
     * @var string|null
     * @ORM\Column(name="companyContact", length=100)
     */
    private $companyContact;

    /**
     * @var string|null
     * @ORM\Column(name="companyAddress", length=255)
     */
    private $companyAddress;

    /**
     * @var string|null
     * @ORM\Column(name="companyEmail", type="text")
     */
    private $companyEmail;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="companyCCFamily")
     */
    private $companyCCFamily;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="companyPhone")
     */
    private $companyPhone;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="companyAll")
     */
    private $companyAll;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="gibbonFinanceFeeCategoryIDList")
     */
    private $financeFeeCategoryList;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="agreement")
     */
    private $agreement;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="parent1gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=true)
     */
    private $parent1;

    /**
     * @var string|null
     * @ORM\Column(length=5, name="parent1Title", nullable=true)
     */
    private $parent1Title;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="parent1Surname")
     */
    private $parent1Surname;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="parent1FirstName")
     */
    private $parent1FirstName;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="parent1preferredName")
     */
    private $parent1preferredName;

    /**
     * @var string|null
     * @ORM\Column(length=150, name="parent1officialName")
     */
    private $parent1officialName;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="parent1nameInCharacters")
     */
    private $parent1nameInCharacters;

    /**
     * @var string|null
     * @ORM\Column(length=12, name="parent1Gender")
     */
    private $parent1Gender = 'M';

    /**
     * @var string|null
     * @ORM\Column(length=50, name="parent1relationship", nullable=true)
     */
    private $parent1relationship;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent1languageFirst", nullable=true)
     */
    private $parent1languageFirst;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent1languageSecond", nullable=true)
     */
    private $parent1languageSecond;

    /**
     * @var string|null
     * @ORM\Column(length=255, name="parent1citizenship1", nullable=true)
     */
    private $parent1citizenship1;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent1nationalIDCardNumber", nullable=true)
     */
    private $parent1nationalIDCardNumber;

    /**
     * @var string|null
     * @ORM\Column(length=255, name="parent1residencyStatus", nullable=true)
     */
    private $parent1residencyStatus;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="parent1visaExpiryDate", nullable=true)
     */
    private $parent1visaExpiryDate;

    /**
     * @var string|null
     * @ORM\Column(length=75, name="parent1email", nullable=true)
     */
    private $parent1email;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="parent1phone1Type", nullable=true)
     */
    private $parent1phone1Type;

    /**
     * @var string|null
     * @ORM\Column(length=7, name="parent1phone1CountryCode", nullable=true)
     */
    private $parent1phone1CountryCode;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="parent1phone1", nullable=true)
     */
    private $parent1phone1;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="parent1phone2Type", nullable=true)
     */
    private $parent1phone2Type;

    /**
     * @var string|null
     * @ORM\Column(length=7, name="parent1phone2CountryCode", nullable=true)
     */
    private $parent1phone2CountryCode;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="parent1phone2", nullable=true)
     */
    private $parent1phone2;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent1profession", nullable=true)
     */
    private $parent1profession;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent1employer", nullable=true)
     */
    private $parent1employer;

    /**
     * @var string|null
     * @ORM\Column(length=5, name="parent2Title", nullable=true)
     */
    private $parent2Title;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="parent2Surname")
     */
    private $parent2Surname;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="parent2FirstName")
     */
    private $parent2FirstName;

    /**
     * @var string|null
     * @ORM\Column(length=60, name="parent2preferredName")
     */
    private $parent2preferredName;

    /**
     * @var string|null
     * @ORM\Column(length=150, name="parent2officialName")
     */
    private $parent2officialName;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="parent2nameInCharacters")
     */
    private $parent2nameInCharacters;

    /**
     * @var string|null
     * @ORM\Column(length=12, name="parent2Gender")
     */
    private $parent2Gender = 'M';

    /**
     * @var string|null
     * @ORM\Column(length=50, name="parent2relationship", nullable=true)
     */
    private $parent2relationship;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent2languageFirst", nullable=true)
     */
    private $parent2languageFirst;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent2languageSecond", nullable=true)
     */
    private $parent2languageSecond;

    /**
     * @var string|null
     * @ORM\Column(length=255, name="parent2citizenship1", nullable=true)
     */
    private $parent2citizenship1;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent2nationalIDCardNumber", nullable=true)
     */
    private $parent2nationalIDCardNumber;

    /**
     * @var string|null
     * @ORM\Column(length=255, name="parent2residencyStatus", nullable=true)
     */
    private $parent2residencyStatus;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="parent2visaExpiryDate", nullable=true)
     */
    private $parent2visaExpiryDate;

    /**
     * @var string|null
     * @ORM\Column(length=75, name="parent2email", nullable=true)
     */
    private $parent2email;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="parent2phone1Type", nullable=true)
     */
    private $parent2phone1Type;

    /**
     * @var string|null
     * @ORM\Column(length=7, name="parent2phone1CountryCode", nullable=true)
     */
    private $parent2phone1CountryCode;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="parent2phone1", nullable=true)
     */
    private $parent2phone1;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="parent2phone2Type", nullable=true)
     */
    private $parent2phone2Type;

    /**
     * @var string|null
     * @ORM\Column(length=7, name="parent2phone2CountryCode", nullable=true)
     */
    private $parent2phone2CountryCode;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="parent2phone2", nullable=true)
     */
    private $parent2phone2;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent2profession", nullable=true)
     */
    private $parent2profession;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="parent2employer", nullable=true)
     */
    private $parent2employer;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="timestamp", nullable=true)
     */
    private $timestamp;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="priority", columnDefinition="INT(1)")
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
     * @ORM\Column(type="date", name="dateStart")
     */
    private $dateStart;

    /**
     * @var RollGroup|null
     * @ORM\ManyToOne(targetEntity="RollGroup")
     * @ORM\JoinColumn(name="gibbonRollGroupID", referencedColumnName="gibbonRollGroupID", nullable=true)
     */
    private $rollGroup;

    /**
     * @var Family|null
     * @ORM\ManyToOne(targetEntity="Family")
     * @ORM\JoinColumn(name="gibbonFamilyID", referencedColumnName="gibbonFamilyID", nullable=true)
     */
    private $family;

    /**
     * @var string|null
     * @ORM\Column(name="howDidYouHear", nullable=true)
     */
    private $howDidYouHear;

    /**
     * @var string|null
     * @ORM\Column(name="howDidYouHearMore", nullable=true)
     */
    private $howDidYouHearMore;

    /**
     * @var string|null
     * @ORM\Column(name="paymentMade", length=10)
     */
    private $paymentMade = 'N';

    /**
     * @var Payment|null
     * @ORM\ManyToOne(targetEntity="Payment")
     * @ORM\JoinColumn(name="gibbonPaymentID", referencedColumnName="gibbonPaymentID", nullable=true)
     */
    private $paymentRecord;

    /**
     * @var string|null
     * @ORM\Column(name="studentID", nullable=true, length=10)
     */
    private $studentID;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $privacy;

    /**
     * @var string|null
     * @ORM\Column(type="text", options={"comment": "Serialised array of custom field values"})
     */
    private $fields;

    /**
     * @var string|null
     * @ORM\Column(type="text", options={"comment": "Serialised array of custom field values"})
     */
    private $parent1fields;

    /**
     * @var string|null
     * @ORM\Column(type="text", options={"comment": "Serialised array of custom field values"})
     */
    private $parent2fields;
}