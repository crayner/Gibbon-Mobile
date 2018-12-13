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
 * Date: 12/12/2018
 * Time: 10:35
 */
namespace App\Provider;

use App\Entity\Messenger;
use App\Entity\MessengerTarget;
use App\Manager\Traits\EntityTrait;
use App\Util\UserHelper;
use Doctrine\DBAL\Connection;

/**
 * Class MessengerProvider
 * @package App\Provider
 */
class MessengerProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Messenger::class;

    /**
     * getRoleCategoryMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getRoleCategoryMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $categories = UserHelper::getRoleCategories();
        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.identifier IN (:categories)')
            ->setParameter('date', $date)
            ->setParameter('messageType', 'Role Category')
            ->setParameter('categories', $categories, Connection::PARAM_STR_ARRAY)
            ->getQuery()
            ->getResult();
    }

    /**
     * getIndividualMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getIndividualMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $person = UserHelper::getCurrentUser()->getId();
        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date1 OR m.messageWall_date2 = :date2 OR m.messageWall_date3 = :date3')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.identifier = :person')
            ->setParameter('date1', $date)
            ->setParameter('date2', $date)
            ->setParameter('date3', $date)
            ->setParameter('messageType', 'Individuals')
            ->setParameter('person', $person)
            ->getQuery()
            ->getResult();
    }

    /**
     * getRoleMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getRoleMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $roles = explode(',', UserHelper::getCurrentUser()->getAllRoles());
        dump($roles);
        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date1 OR m.messageWall_date2 = :date2 OR m.messageWall_date3 = :date3')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.identifier IN (:categories)')
            ->setParameter('date1', $date)
            ->setParameter('date2', $date)
            ->setParameter('date3', $date)
            ->setParameter('messageType', 'Role')
            ->setParameter('categories', $roles, Connection::PARAM_STR_ARRAY)
            ->getQuery()
            ->getResult();
    }

    /**
     * getYearGroupStaffMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getYearGroupStaffMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        //Messages by Course Taught in Year and look for role as tutor in Roll Group for the appropriate year group.
        $yearGroups = array_merge(UserHelper::getStaffYearGroupsByCourse(),UserHelper::getStaffYearGroupsByRollGroup());

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.staff = :yes')
            ->andWhere('mt.identifier IN (:yearGroups)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Year Group')
            ->setParameter('yearGroups', $yearGroups, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getYearGroupStudentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getYearGroupStudentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        //Grab the student YearGroup
        $yearGroups = UserHelper::getStudentYearGroup();

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.students = :yes')
            ->andWhere('mt.identifier IN (:yearGroups)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Year Group')
            ->setParameter('yearGroups', $yearGroups, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getYearGroupParentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getYearGroupParentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        //Grab the student YearGroup
        $yearGroups = UserHelper::getParentYearGroups();

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.parents = :yes')
            ->andWhere('mt.identifier IN (:yearGroups)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Year Group')
            ->setParameter('yearGroups', $yearGroups, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getRollGroupStaffMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getRollGroupStaffMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        //Grab the Staff RollGroup
        $rollGroups = UserHelper::getStaffRollGroups('id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.staff = :yes')
            ->andWhere('mt.identifier IN (:yearGroups)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Roll Group')
            ->setParameter('yearGroups', $rollGroups, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getRollGroupStudentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getRollGroupStudentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        //Grab the student RollGroup
        $rollGroups = UserHelper::getStudentRollGroups('id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.students = :yes')
            ->andWhere('mt.identifier IN (:yearGroups)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Roll Group')
            ->setParameter('yearGroups', $rollGroups, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getRollGroupStudentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getRollGroupParentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        //Grab the student RollGroup
        $rollGroups = UserHelper::getParentRollGroups('id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.parents = :yes')
            ->andWhere('mt.identifier IN (:yearGroups)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Roll Group')
            ->setParameter('yearGroups', $rollGroups, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getCourseStaffMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getCourseStaffMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        //Grab the student RollGroup
        $courses = UserHelper::getCoursesByPerson(null,'id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.staff = :yes')
            ->andWhere('mt.identifier IN (:courses)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Course')
            ->setParameter('courses', $courses, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getCourseStudentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getCourseStudentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        //Grab the student RollGroup
        $courses = UserHelper::getCoursesByPerson(null,'id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.students = :yes')
            ->andWhere('mt.identifier IN (:courses)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Course')
            ->setParameter('courses', $courses, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getCourseParentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getCourseParentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $children = UserHelper::getChildrenOfParent();

        $courses = [];
        foreach($children as $child)
            $courses = array_merge($courses, UserHelper::getCoursesByPerson($child,'id'));

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.parents = :yes')
            ->andWhere('mt.identifier IN (:courses)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Course')
            ->setParameter('courses', $courses, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getCourseClassStaffMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getCourseClassStaffMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $classes = UserHelper::getCourseClassesByPerson(null,'id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.staff = :yes')
            ->andWhere('mt.identifier IN (:classes)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Class')
            ->setParameter('classes', $classes, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getCourseClassStaffMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getCourseClassStudentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $classes = UserHelper::getCourseClassesByPerson(null,'id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.students = :yes')
            ->andWhere('mt.identifier IN (:classes)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Class')
            ->setParameter('classes', $classes, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getCourseClassStaffMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getCourseClassParentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $children = UserHelper::getChildrenOfParent();

        $classes = [];
        foreach($children as $child)
            $classes = array_merge($classes, UserHelper::getCourseClassesByPerson($child,'id'));


        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.parents = :yes')
            ->andWhere('mt.identifier IN (:classes)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Class')
            ->setParameter('classes', $classes, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getMessagesByType
     * @param string $showDate
     * @param string $timezone
     * @return mixed
     * @throws \Exception
     */
    public function getMessagesByType(string $showDate = 'today', string $timezone = 'UTC')
    {
        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt', 'mt.type')
            ->select('mt.type, COUNT(mt.id)')
            ->leftJoin('mt.messenger', 'm')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date AND m.messageWall = :yes')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->addGroupBy('mt.type')
            ->getQuery()
            ->getResult();

    }

    /**
     * getCourseClassStaffMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getActivityStaffMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $activities = UserHelper::getActivitiesByStaff('id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.staff = :yes')
            ->andWhere('mt.identifier IN (:activities)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Activity')
            ->setParameter('activities', $activities, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getActivityStudentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getActivityStudentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $activities = UserHelper::getActivitiesByStudent(null, 'id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.students = :yes')
            ->andWhere('mt.identifier IN (:activities)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Activity')
            ->setParameter('activities', $activities, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getActivityStudentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getActivityParentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $activities = UserHelper::getActivitiesByParent('id');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.students = :yes')
            ->andWhere('mt.identifier IN (:activities)')
            ->setParameter('date', $date)
            ->setParameter('yes', 'Y')
            ->setParameter('messageType', 'Activity')
            ->setParameter('activities', $activities, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult() ?: [];
    }

    /**
     * getHouseMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getHouseMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $house = UserHelper::getCurrentUser()->getHouse();
        if (empty($house))
            return [];

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.identifier = :house')
            ->setParameter('date', $date)
            ->setParameter('messageType', 'Houses')
            ->setParameter('house', $house->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * getAttendanceStudentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getAttendanceStudentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $attendanceType = [];
        foreach(UserHelper::getStudentAttendance($showDate, $timezone) as $alp)
            $attendanceType[] = $alp->getType().$alp->getDate()->format(' Y-m-d');

        $date = new \DateTime($showDate, new \DateTimeZone($timezone));
        $date = $date->format('Y-m-d');

        return $this->getRepository(MessengerTarget::class)->createQueryBuilder('mt')
            ->select('mt, m, p')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('mt.messenger', 'm')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->andWhere('mt.identifier IN (:attendanceType)')
            ->setParameter('date', $date)
            ->setParameter('messageType', 'Attendance')
            ->setParameter('attendanceType', $attendanceType, Connection::PARAM_STR_ARRAY)
            ->getQuery()
            ->getResult();
    }

    /**
     * getAttendanceParentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getAttendanceParentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $results = [];
        foreach(UserHelper::getChildrenOfParent() as $child)
            $results = array_merge($results, UserHelper::getStudentAttendance($showDate, $timezone, $child));

        return $results;
    }
}