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
 * Date: 6/03/2019
 * Time: 16:51
 */
namespace App\Tests\Controller;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SecurityControllerTest
 * @package App\Tests\Controller
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * @const string
     */
    CONST PASSWORD = 'hG6249nmx8u3$';

    /**
     * @const string
     */
    CONST SALT = 'wdfyhb79r3gf7349t65r4gfb8eybf843';

    /**
     * @const string
     */
    CONST USERNAME = 'system_admin';

    /**
     * testNothingYet
     */
    public function testNothingYet()
    {
        $this->assertEquals(2, 1+1);
    }

    /**
     * definePerson
     * @param Person|null $person
     * @return Person
     */
    public static function definePerson(Person $person = null)
    {
        $person = $person ?: new Person();
        $person->setUsername(self::USERNAME)
            ->setTitle('')
            ->setSurname('System')
            ->setFirstName('Administrator')
            ->setPreferredName('System Administrator')
            ->setOfficialName('System Administrator')
            ->setNameInCharacters('')
            ->setGender('Unspecified')
            ->setMD5Password('')
            ->setStatus('Full')
            ->setCanLogin('Y')
            ->setAllRoles('')
            ->setLastIPAddress('')
            ->setAddress1('')
            ->setAddress1District('')
            ->setAddress1Country('')
            ->setAddress2('')
            ->setAddress2District('')
            ->setAddress2Country('')
            ->setPhone1Type('')
            ->setPhone1CountryCode('')
            ->setPhone1('')
            ->setPhone2Type('')
            ->setPhone2CountryCode('')
            ->setPhone2('')
            ->setPhone3Type('')
            ->setPhone3CountryCode('')
            ->setPhone3('')
            ->setPhone4Type('')
            ->setPhone4CountryCode('')
            ->setPhone4('')
            ->setWebsite('')
            ->setLanguageFirst('en_GB')
            ->setLanguageSecond('')
            ->setLanguageThird('')
            ->setCountryOfBirth('')
            ->setBirthCertificateScan('')
            ->setEthnicity('');
        $person->setCitizenship1('');
        $person->setCitizenship1Passport('');
        $person->setCitizenship1PassportScan('');
        $person->setCitizenship2('');
        $person->setCitizenship2Passport('');
        $person->setReligion('');
        $person->setNationalIDCardNumber('');
        $person->setNationalIDCardScan('');
        $person->setResidencyStatus('');
        $person->setProfession('');
        $person->setEmployer('');
        $person->setJobTitle('');
        $person->setEmergency1Name('');
        $person->setEmergency1Number1('');
        $person->setEmergency1Number2('');
        $person->setEmergency1Relationship('');
        $person->setEmergency2Name('');
        $person->setEmergency2Number1('');
        $person->setEmergency2Number2('');
        $person->setEmergency2Relationship('');
        $person->setStudentID('');
        $person->setLastSchool('');
        $person->setNextSchool('');
        $person->setDepartureReason('');
        $person->setTransport('');
        $person->setTransportNotes('');
        $person->setCalendarFeedPersonal('');
        $person->setViewCalendarSchool('Y');
        $person->setViewCalendarPersonal('Y');
        $person->setViewCalendarSpaceBooking('Y');
        $person->setLockerNumber('');
        $person->setVehicleRegistration('');
        $person->setPersonalBackground('');
        $person->setGoogleAPIRefreshToken('');
        $person->setReceiveNotificationEmails('Y');

        return $person;
    }
}