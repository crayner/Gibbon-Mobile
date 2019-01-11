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
 * Date: 8/01/2019
 * Time: 10:46
 */
namespace App\Manager;


use App\Entity\AttendanceCode;
use App\Entity\AttendanceLogCourseClass;
use App\Entity\AttendanceLogPerson;
use App\Entity\CourseClass;
use App\Entity\Person;
use App\Entity\TTDayRowClass;
use App\Provider\AttendanceCodeProvider;
use App\Util\TimetableHelper;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AttendanceManager
 * @package App\Manager
 */
class AttendanceManager
{
    /**
     * Attendance Types
     * @var array
     */
    private $attendanceTypes = [];

    /**
     * @var array
     */
    private $genericReasons = [];

    /**
     * @var array
     */
    private $medicalReasons = [];

    /**
     * @var array
     */
    private $attendanceReasons = [];

    /**
     * @var \DateTime|null
     */
    private $currentDate;

    /**
     * @var TTDayRowClass|null
     */
    private $TTDayRowClass;

    /**
     * @var bool
     */
    private $canTakeAttendance = true;

    /**
     * @var MessageManager|null
     */
    private $messageManager;

    /**
     * @var AttendanceCodeProvider
     */
    private $provider;

    /**
     * AttendanceManager constructor.
     */
    public function __construct(AttendanceCodeProvider $attendanceCodeProvider, SettingManager $settingManager)
    {
        $this->attendanceTypes = $attendanceCodeProvider->findActive(true);

        $this->provider = $attendanceCodeProvider;
        // Get attendance reasons
        $this->genericReasons = $settingManager->getSettingByScopeAsArray('Attendance', 'attendanceReasons');
        $this->medicalReasons = $settingManager->getSettingByScopeAsArray('Attendance', 'attendanceMedicalReasons');

        $this->attendanceReasons = $this->genericReasons ?: [];
        $this->messageManager = $settingManager->getMessageManager();
    }

    /**
     * @return \DateTime|null
     */
    public function getCurrentDate(): ?\DateTime
    {
        return $this->currentDate;
    }

    /**
     * @param \DateTime|null $currentDate
     * @return AttendanceManager
     */
    public function setCurrentDate(?\DateTime $currentDate): AttendanceManager
    {
        $this->currentDate = $currentDate;
        $this->isSchoolOpen();
        $this->isDateInFuture();
        return $this;
    }

    /**
     * @return TTDayRowClass|null
     */
    public function getTTDayRowClass(): ?TTDayRowClass
    {
        return $this->TTDayRowClass;
    }

    /**
     * @param TTDayRowClass|null $TTDayRowClass
     * @return AttendanceManager
     */
    public function setTTDayRowClass(?TTDayRowClass $TTDayRowClass): AttendanceManager
    {
        $this->TTDayRowClass = $TTDayRowClass;
        $this->isAttendanceRequired();
        return $this;
    }


    public function takeClassAttendance(TTDayRowClass $class, \DateTime $date)
    {
        $this->setTTDayRowClass($class);
        $this->setCurrentDate($date);
    }

    /**
     * @var bool
     */
    private $dateInFuture = true;

    /**
     * @var bool
     */
    private $schoolOpen = false;

    /**
     * isDateInFuture
     * @return bool
     * @throws \Exception
     */
    public function isDateInFuture(): bool
    {
        $periodTime = clone $this->getCurrentDate();
        $start = $this->getTTDayRowClass()->getTTColumnRow()->getTimeStart();
        $periodTime->add(new \DateInterval('PT'.$start->format('H\Hi\M')));
        if ($periodTime->getTimestamp() > strtotime('+5 Minutes')) {
            $this->getMessageManager()->add('danger', 'Your request failed because the specified date is in the future, or is not a school day.');
            return $this->dateInFuture = true;
        }
        return $this->dateInFuture = false;
    }

    /**
     * @return MessageManager
     */
    public function getMessageManager(): MessageManager
    {
        return $this->messageManager;
    }

    /**
     * isSchoolOpen
     * @return bool
     * @throws \Exception
     */
    public function isSchoolOpen(): bool
    {
        if (! $this->schoolOpen = TimetableHelper::isSchoolOpen($this->getCurrentDate()) || true) {
            $this->getMessageManager()->add('danger', 'Your request failed because the specified date is in the future, or is not a school day.');
        }
        return $this->schoolOpen;
    }

    /**
     * getProvider
     * @return AttendanceCodeProvider
     */
    public function getProvider(): AttendanceCodeProvider
    {
        return $this->provider;
    }

    private $students;

    /**
     * getStudents
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        $this->students = $this->getTTDayRowClass()->getCourseClass()->getStudents();
        return $this->students;
    }

    /**
     * @var bool
     */
    private $attendanceRequired;

    /**
     * isAttendanceRequired
     * @return bool
     */
    public function isAttendanceRequired(): bool
    {
        if (is_null($this->attendanceRequired)) {
            $this->attendanceRequired = $this->getTTDayRowClass()->getCourseClass()->getAttendance() === 'Y' ? true : false;
            if (!$this->attendanceRequired) {
                $this->getMessageManager()->add('warning', '');
            }
        }
        return $this->attendanceRequired;
    }

    /**
     * __toArray
     * @return array
     * @throws \Exception
     */
    public function __toArray(): array
    {
        if (! $this->isAttendanceRequired() || ! $this->isSchoolOpen() || $this->isDateInFuture())
            return [];

        $result = [];
        $result['TTDayRowClass'] = $this->getTTDayRowClass()->__toArray();
        $result['courseClass'] = $this->getCourseClass()->__toArray(["courseClassPeople","TTDayRowClasses","students"]);
        $result['courseClass']['course'] = $this->getCourseClass()->getCourse()->__toArray(['courseClasses','schoolYear','department']);
        $result['date'] = $this->getCurrentDate();
        $result['students'] = $this->createStudentAttendanceList();
        $result['type'] = 'courseClass';
        $result['codes'] = $this->attendanceTypes;

        return $result;
    }

    /**
     * getCourseClass
     * @return CourseClass
     */
    private function getCourseClass(): CourseClass
    {
        return $this->getTTDayRowClass()->getCourseClass();
    }

    /**
     * @var array
     */
    private $attendance;

    /**
     * createStudentAttendanceList
     * @return array
     * @throws \Exception
     */
    private function createStudentAttendanceList(): array
    {
        $results = $this->getProvider()->getRepository(AttendanceLogPerson::class)->findClassStudents($this->getCourseClass(), $this->getCurrentDate());
        if (empty($results))
            $this->getMessageManager()->add('info', 'Attendance has not been taken for this group yet for the specified date. The entries below are a best-guess based on defaults and information put into the system in advance, not actual data.');
        foreach($results as $attendanceRecord)
        {
            $result = [];
            $result['attendance']['code'] = $attendanceRecord->getAttendanceCode()->getId();
            $this->attendance[$attendanceRecord->getPerson()->getId()] = $result;
        }

        foreach($this->getStudents() as $student)
        {
            $id = $student->getPerson()->getId();
            $result = isset($this->attendance[$id]) ? $this->attendance[$id] : [];
            $result['person']['id'] = $id;
            $result['person']['name'] = $student->getPerson()->formatName(true, true, true);
            $result['person']['photo'] = $student->getPerson()->getImage240(true);
            $result['attendance']['code'] = isset($result['attendance']['code']) ? $result['attendance']['code'] : $this->getProvider()->getRepository(AttendanceCode::class)->findDefaultAttendanceCode()->getId();
            $this->attendance[$id] = $result;
        }

        return $this->attendance;
    }

    /**
     * getRepository
     * @param string|null $className
     * @return ObjectRepository
     * @throws \Exception
     */
    private function getRepository(?string $className = null): ObjectRepository
    {
        return $this->getProvider()->getRepository($className);
    }

    /**
     * handleClassRequest
     * @param Request $request
     * @throws \Exception
     */
    public function handleClassRequest(Request $request)
    {
        $content = json_decode($request->getContent());
        $this->setTTDayRowClass($this->getRepository(TTDayRowClass::class)->find($content->TTDayRowClass->id));
        $this->setCurrentDate(new \DateTime($content->date->date, new \DateTimeZone($content->date->timezone)));

        $alcc = $this->getRepository(AttendanceLogCourseClass::class)->findOneBy(['courseClass' => $this->getCourseClass(), 'date' => $this->getCurrentDate()]);
        $students = $this->getRepository(AttendanceLogPerson::class)->findClassStudents($this->getCourseClass(), $this->getCurrentDate());

        $alcc = $alcc ?: new AttendanceLogCourseClass();
        $alcc->setCourseClass($this->getCourseClass());
        $alcc->setDate($this->getCurrentDate());
        $codes = [];
        foreach($content->students as $student)
        {
            if (empty($students[$student->person->id]))
            {
                $alp = new AttendanceLogPerson();
            }
            $students[$student->person->id] = $alp;
            $code = $student->attendance->code;
            $code = isset($codes[$code]) ? $codes[$code] : $this->getRepository(AttendanceCode::class)->find($code);
            $alp->setAttendanceCode($code)
                ->setPerson($this->getRepository(Person::class)->find($student->person->id))
                ->setDate($this->getCurrentDate())
                ->setCourseClass($this->getCourseClass())
                ->setReason('')
                ->setComment('')
            ;
            $this->getProvider()->getEntityManager()->persist($alp);
        }
        $this->getProvider()->getEntityManager()->persist($alcc);
        $this->getProvider()->getEntityManager()->flush();
        $this->getMessageManager()->add('Success', 'Your request was completed successfully.');
    }
}