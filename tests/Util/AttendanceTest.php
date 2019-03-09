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
 * Date: 9/03/2019
 * Time: 21:45
 */
namespace App\Tests\Util;

use App\Entity\TTDayDate;
use App\Manager\AttendanceManager;
use App\Manager\MessageManager;
use App\Manager\SchoolYearManager;
use App\Provider\AttendanceCodeProvider;
use App\Provider\PersonProvider;
use App\Provider\SchoolYearProvider;
use App\Provider\SettingProvider;
use App\Provider\TimetableProvider;
use App\Util\SchoolYearHelper;
use App\Util\TimetableHelper;
use App\Util\UserHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class AttendanceTest
 * @package App\Tests\Util
 */
class AttendanceTest extends WebTestCase
{
    /**
     * @var AttendanceManager
     */
    private $manager;

    private $date;

    private $session;

    /**
     * setUp
     * @throws \Exception
     */
    public function setUp(): void
    {
        self::bootKernel();

        $this->session = new Session(new MockArraySessionStorage());
        if (! $this->session->isStarted())
            $this->session->start();
        $mm = new MessageManager();
        $provider = new AttendanceCodeProvider(self::$container->get('doctrine')->getManager(), $mm,
            self::$container->get('security.authorization_checker'), self::$container->get('router'));
        new TimetableHelper(new TimetableProvider(self::$container->get('doctrine')->getManager(), $mm,
            self::$container->get('security.authorization_checker'), self::$container->get('router')));
        $stack = self::$container->get('request_stack');
        $syp = new SchoolYearProvider(self::$container->get('doctrine')->getManager(), $mm,
            self::$container->get('security.authorization_checker'), self::$container->get('router'));
        $sym = new SchoolYearManager($stack, $syp, $this->session);
        $ts = self::$container->get('security.token_storage');
        $pp = new PersonProvider(self::$container->get('doctrine')->getManager(), $mm,
            self::$container->get('security.authorization_checker'), self::$container->get('router'));
        new SchoolYearHelper($sym, new UserHelper($ts, $pp));
        $settingProvider = new SettingProvider(self::$kernel->getContainer(), $mm);

        $this->manager = new AttendanceManager($provider, $settingProvider);

        $this->date = new \DateTimeImmutable('now', new \DateTimeZone(self::$container->getParameter('timezone')));

    }

    /**
     * testAttendance
     * @throws \Exception
     */
    public function testAttendance()
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($this->date->getTimestamp());
        $interval = new \DateInterval('P1D');
        $tomorrow = clone $dateTime;
        $tomorrow->add($interval);
        $this->manager->setCurrentDate($dateTime);
        $this->assertFalse($this->manager->isDateInFuture(), 'Today is not in the future ' . $dateTime->format('Y-m-d'));
/*
        while (! $this->manager->isSchoolOpen()) {
            $dateTime->sub($interval);
            $this->manager->setCurrentDate($dateTime);
        }
        $this->assertTrue($this->manager->isSchoolOpen(), 'The school should be Open on '.$dateTime->format('Y-m-d'));

        $currentYear = SchoolYearHelper::getCurrentSchoolYear();

        $ttDayDate = $this->manager->getProvider()->getRepository(TTDayDate::class)->findBy(['date' => $dateTime]);
        $ttDayDate = reset($ttDayDate);
        $ttDay = $ttDayDate->getTTDay();
        $ttDayRowClasses = $ttDay->getTTDayRowClasses();
        $class = $ttDayRowClasses->first();
        $this->manager->takeClassAttendance($class, $dateTime);
        if ($class->getCourseClass()->getAttendance() === 'Y')
            $this->assertTrue($this->manager->isAttendanceRequired(), 'Attendance is required.');
        else
            $this->assertFalse($this->manager->isAttendanceRequired(), 'Attendance is not required.');

        $this->assertGreaterThan(0, $this->manager->getStudents()->count(), 'Number of students in the class');
        $this->manager->setCurrentDate($tomorrow);
        $this->assertTrue($this->manager->isDateInFuture(), 'Tomorrow is in the future ' . $tomorrow->format('Y-m-d')); */
    }

    /**
     * teardown
     */
    public function teardown(): void
    {
        $this->manager = null;
        $this->date = null;
        $this->session = null;
    }
}