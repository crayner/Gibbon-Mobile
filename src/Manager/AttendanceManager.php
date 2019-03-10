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
 * Date: 8/01/2019
 * Time: 10:46
 */
namespace App\Manager;

use App\Entity\AttendanceCode;
use App\Entity\AttendanceLogCourseClass;
use App\Entity\AttendanceLogPerson;
use App\Entity\AttendanceLogRollGroup;
use App\Entity\CourseClass;
use App\Entity\Person;
use App\Entity\RollGroup;
use App\Entity\TTDayRowClass;
use App\Provider\AttendanceCodeProvider;
use App\Provider\SettingProvider;
use App\Util\TimetableHelper;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @var MessageManager|null
     */
    private $messageManager;

    /**
     * @var AttendanceCodeProvider
     */
    private $provider;

    /**
     * @var SettingProvider 
     */
    private $settingProvider;

    /**
     * AttendanceManager constructor.
     */
    public function __construct(AttendanceCodeProvider $attendanceCodeProvider, SettingProvider $provider)
    {
        $this->attendanceTypes = $attendanceCodeProvider->findActive(true);

        $this->provider = $attendanceCodeProvider;
        // Get attendance reasons
        $this->settingProvider = $provider;
        $this->genericReasons = $provider->getSettingByScopeAsArray('Attendance', 'attendanceReasons');
        $this->medicalReasons = $provider->getSettingByScopeAsArray('Attendance', 'attendanceMedicalReasons');
        $this->attendanceReasons = $this->genericReasons ?: [];
        $this->messageManager = $provider->getMessageManager();
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
        $this->isPeriodInFuture();
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
        if (! is_null($TTDayRowClass)) $this->setRollGroup(null);
        $this->isAttendanceRequired(true);
        return $this;
    }

    /**
     * takeClassAttendance
     * @param TTDayRowClass $class
     * @param \DateTime $date
     */
    public function takeClassAttendance(TTDayRowClass $class, \DateTime $date)
    {
        $this->setTTDayRowClass($class);
        $this->setCurrentDate($date);
    }

    /**
     * @var bool
     */
    private $schoolOpen = false;

    /**
     * isPeriodInFuture
     * @return bool
     * @throws \Exception
     */
    public function isPeriodInFuture(): bool
    {
        $periodTime = clone $this->getCurrentDate();
        if ($this->getTTDayRowClass()) {
            $start = $this->getTTDayRowClass()->getTTColumnRow()->getTimeStart();
            $periodTime->add(new \DateInterval('PT' . $start->format('H\Hi\M')));
            if ($periodTime->getTimestamp() > strtotime('+5 Minutes')) {
                $this->getMessageManager()->add('danger', 'Your request failed because the specified date is in the future, or is not a school day.');
                return true;
            }
        } elseif ($this->getRollGroup()) {
            if ($this->getCurrentDate()->getTimestamp() > strtotime('+5 Minutes')) {
                $this->getMessageManager()->add('danger', 'Your request failed because the specified date is in the future, or is not a school day.');
                return true;
            }
        }
        return false;
    }

    /**
     * isDateInFuture
     * @return bool
     * @throws \Exception
     */
    public function isDateInFuture(): bool
    {
        $today = (new \DateTime(date('Y-m-d 00:00:00'), new \DateTimeZone($this->settingProvider->getParameter('timezone'))))->format('Y-m-d');
        if ($this->getCurrentDate()->format('Y-m-d') > $today)
            return true;
        return false;
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
        if (! $this->schoolOpen = TimetableHelper::isSchoolOpen($this->getCurrentDate())) {
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

    /**
     * @var array
     */
    private $students;

    /**
     * getStudents
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        if ($this->getTTDayRowClass()) {
            $this->students = $this->getTTDayRowClass()->getCourseClass()->getStudents();
        } elseif ($this->getRollGroup()) {
            $this->students = $this->getRollGroup()->getStudentEnrolments();
        }
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
    public function isAttendanceRequired(bool $refresh = false): bool
    {
        if (is_null($this->attendanceRequired) || $refresh) {
            if ($this->getTTDayRowClass()) {
                $this->attendanceRequired = $this->getTTDayRowClass()->getCourseClass()->getAttendance() === 'Y' ? true : false;
                if (!$this->attendanceRequired) {
                    $this->getMessageManager()->add('warning', 'Attendance is not required.');
                }
            } elseif ($this->getRollGroup()) {
                $this->attendanceRequired = $this->getRollGroup()->getAttendance() === 'Y' ? true : false;
                if (!$this->attendanceRequired) {
                    $this->getMessageManager()->add('warning', 'Attendance is not required.');
                }
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
        if (! $this->isAttendanceRequired() || ! $this->isSchoolOpen() || $this->isPeriodInFuture())
            return [];

        $result = [];
        if ($this->getTTDayRowClass()) {
            $result['TTDayRowClass'] = $this->getTTDayRowClass()->__toArray();
            $result['courseClass'] = $this->getCourseClass()->__toArray(["courseClassPeople", "TTDayRowClasses", "students"]);
            $result['courseClass']['course'] = $this->getCourseClass()->getCourse()->__toArray(['courseClasses', 'schoolYear', 'department']);
            $result['type'] = 'courseClass';
        }
        if ($this->getRollGroup()) {
            $result['rollGroup'] = $this->getRollGroup()->__toArray();
            $result['type'] = 'rollGroup';
        }
        $result['students'] = $this->createStudentAttendanceList();
        $result['date'] = $this->getCurrentDate();
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
        $results = [];
        if ($this->getTTDayRowClass()) {
            $results = $this->getProvider()->getRepository(AttendanceLogPerson::class)->findClassStudents($this->getCourseClass(), $this->getCurrentDate());
        } elseif ($this->getRollGroup()) {
            $results = $this->getProvider()->getRepository(AttendanceLogPerson::class)->findRollStudents($this->getCurrentDate());
        }
        if (empty($results))
            $this->getMessageManager()->add('info', 'Attendance has not been taken for this group yet for the specified date. The entries below are a best-guess based on defaults and information put into the system in advance, not actual data.');
        foreach($results as $attendanceRecord)
        {
            $result = [];
            $result['attendanceCode'] = $attendanceRecord->getAttendanceCode()->getId();
            $this->attendance[$attendanceRecord->getPerson()->getId()] = $result;
        }

        foreach($this->getStudents() as $student)
        {
            $id = $student->getPerson()->getId();
            $result = isset($this->attendance[$id]) ? $this->attendance[$id] : [];
            $result['id'] = $id;
            $result['name'] = $student->getPerson()->formatName(true, true, true);
            $result['photo'] = $student->getPerson()->getImage240(true);
            $result['attendanceCode'] = isset($result['attendanceCode']) ? $result['attendanceCode'] : ($this->guessStudentAttendanceCode($student->getPerson(), isset($result['attendance']['code']) ? $result['attendance']['code'] : $this->getProvider()->getRepository(AttendanceCode::class)->findDefaultAttendanceCode()->getId()));
            $this->attendance[$id] = $result;
        }
        $students = new ArrayCollection($this->attendance);
        $iterator = $students->getIterator();
        $iterator->uasort(
            function ($a, $b) {
                return $a['name'] < $b['name'] ? -1 : 1;
            }
        );
        $this->attendance = [];
        foreach(iterator_to_array($iterator, false) as $student)
            $this->attendance[$student['name']] = $student;

        return $this->attendance;
    }

    /**
     * guessStudentAttendanceCode
     * @param Person $student
     * @param int $code
     * @return int
     * @throws \Exception
     */
    private function guessStudentAttendanceCode(Person $student, int $code): int
    {
        $attendanceRecord = $this->getRepository(AttendanceLogPerson::class)->findBy(['person' => $student, 'date' => $this->getCurrentDate()]);
        $in = 0;
        $out = 0;
        $rollGroup = null;
        $future = null;
        $selfRegistration = null;
        foreach($attendanceRecord as $record) {
            if ($record->getDirection() === 'In') {
                $in++;
            } else {
                $out++;
            }
            if ($record->getContext() === 'Roll Group')
            {
                $rollGroup = $record;
            }
            if ($record->getContext() === 'Future')
            {
                $future = $record;
            }
            if ($record->getContext() === 'Self Registration')
            {
                $selfRegistration = $record;
            }
        }

        if (count($attendanceRecord) === 0) return $code;

        if (count($attendanceRecord) === $in) return 1;

        if (count($attendanceRecord) === $out) return 4;

        if (is_null($rollGroup) && is_null($future) && is_null($selfRegistration)) return $code;
        elseif ($selfRegistration) return $selfRegistration->getAttendanceCode()->getId();
        elseif ($future) return $future->getAttendanceCode()->getId();
        elseif ($rollGroup) return $rollGroup->getAttendanceCode()->getId();
        return $code;
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

        $alcc = $this->getRepository(AttendanceLogCourseClass::class)->findOneBy(['courseClass' => $this->getCourseClass(), 'date' => $this->getCurrentDate()]) ?: new AttendanceLogCourseClass();
        $students = $this->getRepository(AttendanceLogPerson::class)->findClassStudents($this->getCourseClass(), $this->getCurrentDate());

        $alcc->setCourseClass($this->getCourseClass());
        $alcc->setDate($this->getCurrentDate());
        $codes = [];
        foreach($content->students as $student)
        {
            if (empty($students[$student->id])) {
                $alp = new AttendanceLogPerson();
            } else {
                $alp = $students[$student->id];
            }
            $students[$student->id] = $alp;
            $code = $student->attendanceCode;
            $code = isset($codes[$code]) ? $codes[$code] : $this->getRepository(AttendanceCode::class)->find($code);
            $alp->setAttendanceCode($code)
                ->setPerson($this->getRepository(Person::class)->find($student->id))
                ->setDate($this->getCurrentDate())
                ->setCourseClass($this->getCourseClass())
                ->setDirection($code->getDirection())
                ->setType($code->getName())
                ->setContext('Class')
            ;
            $this->getProvider()->getEntityManager()->persist($alp);
        }
        $this->getProvider()->getEntityManager()->persist($alcc);
        $this->getProvider()->getEntityManager()->flush();
        $this->getMessageManager()->add('success', 'Your request was completed successfully.');
    }

    /**
     * @var RollGroup
     */
    private $rollGroup;

    /**
     * takeRollAttendance
     * @param RollGroup $roll
     * @param \DateTime $date
     */
    public function takeRollAttendance(RollGroup $roll, \DateTime $date)
    {
        $this->setRollGroup($roll);
        $this->setCurrentDate($date);
    }

    /**
     * @return RollGroup
     */
    public function getRollGroup(): ?RollGroup
    {
        return $this->rollGroup;
    }

    /**
     * @param RollGroup $rollGroup
     * @return AttendanceManager
     */
    public function setRollGroup(?RollGroup $rollGroup): AttendanceManager
    {
        $this->rollGroup = $rollGroup;
        if (! is_null($rollGroup)) $this->setTTDayRowClass(null);
        $this->isAttendanceRequired(true);
        return $this;
    }

    /**
     * handleRollRequest
     * @param Request $request
     * @throws \Exception
     */
    public function handleRollRequest(Request $request)
    {
        $content = json_decode($request->getContent());
        $this->setRollGroup($this->getRepository(RollGroup::class)->find($content->rollGroup->id));
        $this->setCurrentDate(new \DateTime($content->date->date, new \DateTimeZone($content->date->timezone)));

        $alrg = $this->getRepository(AttendanceLogRollGroup::class)->findOneBy(['rollGroup' => $this->getRollGroup(), 'date' => $this->getCurrentDate()]) ?: new AttendanceLogRollGroup();
        $students = $this->getRepository(AttendanceLogPerson::class)->findRollStudents($this->getCurrentDate());

        $alrg->setRollGroup($this->getRollGroup());
        $alrg->setDate($this->getCurrentDate());
        $codes = [];
        foreach($content->students as $student)
        {
            if (empty($students[$student->id])) {
                $alp = new AttendanceLogPerson();
            } else {
                $alp = $students[$student->id];
            }
            $students[$student->id] = $alp;
            $code = $student->attendanceCode;
            $code = isset($codes[$code]) ? $codes[$code] : $this->getRepository(AttendanceCode::class)->find($code);
            $alp->setAttendanceCode($code)
                ->setPerson($this->getRepository(Person::class)->find($student->id))
                ->setDate($this->getCurrentDate())
                ->setDirection($code->getDirection())
                ->setType($code->getName())
                ->setCourseClass(null)
                ->setContext('Roll Group')
            ;
            $this->getProvider()->getEntityManager()->persist($alp);
        }
        $this->getProvider()->getEntityManager()->persist($alrg);
        $this->getProvider()->getEntityManager()->flush();
        $this->getMessageManager()->add('success', 'Your request was completed successfully.');
    }
}