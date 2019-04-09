<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
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
     * @var array
     */
    private $correctedDate = [];

    /**
     * getMatchingMessages
     * @param string $messageType
     * @param $identifier
     * @param string $showDate
     * @param string $timezone
     * @param string $personType
     * @return mixed
     * @throws \Exception
     */
    private function getMatchingMessages(string $messageType, $identifier, string $showDate = 'today', string $timezone = 'UTC', string $personType = 'any'): array
    {
        if (empty($this->correctedDate) || empty($this->correctedDate[$showDate])) {
            $date = new \DateTime($showDate, new \DateTimeZone($timezone));
            $this->correctedDate[$showDate] = $date->format('Y-m-d');
        }

        return $this->getRepository()->findMatchingMessages($messageType, $identifier, $this->correctedDate[$showDate], $personType);
    }

    /**
     * getRoleCategoryMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getRoleCategoryMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        return $this->getMatchingMessages('Role Category', UserHelper::getRoleCategories(), $showDate, $timezone);
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
        return $this->getMatchingMessages('Individuals', UserHelper::getCurrentUser()->getId(), $showDate, $timezone);
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
        return $this->getMatchingMessages('Role', explode(',', UserHelper::getCurrentUser()->getAllRoles()), $showDate, $timezone);
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
        return $this->getMatchingMessages('Year Group', array_unique(array_merge(UserHelper::getStaffYearGroupsByCourse(),UserHelper::getStaffYearGroupsByRollGroup())), $showDate, $timezone, 'staff');
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
        return $this->getMatchingMessages('Year Group', UserHelper::getStudentYearGroup(), $showDate, $timezone, 'students');
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
        return $this->getMatchingMessages('Year Group', UserHelper::getParentYearGroups(), $showDate, $timezone, 'parents');
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
        return $this->getMatchingMessages('Roll Group', UserHelper::getStaffRollGroups('id'), $showDate, $timezone, 'staff');
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
        return $this->getMatchingMessages('Roll Group', UserHelper::getStudentRollGroups('id'), $showDate, $timezone, 'students');
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
        return $this->getMatchingMessages('Roll Group', UserHelper::getParentRollGroups('id'), $showDate, $timezone, 'parents');
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
        return $this->getMatchingMessages('Course', UserHelper::getCoursesByPerson(null,'id'), $showDate, $timezone, 'staff');
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
        return $this->getMatchingMessages('Course', UserHelper::getCoursesByPerson(null,'id'), $showDate, $timezone, 'students');
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

        return $this->getMatchingMessages('Course', $courses, $showDate, $timezone, 'parents');
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
        return $this->getMatchingMessages('Class',  UserHelper::getCourseClassesByPerson(null,'id'), $showDate, $timezone, 'staff');
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
        return $this->getMatchingMessages('Class',  UserHelper::getCourseClassesByPerson(null,'id'), $showDate, $timezone, 'students');
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

        return $this->getMatchingMessages('Class',  UserHelper::getCourseClassesByPerson(null,'id'), $showDate, $timezone, 'parents');
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
        return $this->getMatchingMessages('Activity',  $activities, $showDate, $timezone, 'staff');
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
        return $this->getMatchingMessages('Activity',  $activities, $showDate, $timezone, 'students');
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
        return $this->getMatchingMessages('Activity',  $activities, $showDate, $timezone, 'parents');
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
        return $this->getMatchingMessages('House',  $house, $showDate, $timezone);
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
        return $this->getMatchingMessages('Attendance',  $attendanceType, $showDate, $timezone, 'students');
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

    /**
     * getTransportMessages
     * @param string $showDate
     * @param string $timezone
     * @param string $transportType
     * @return array
     * @throws \Exception
     */
    public function getTransportStudentMessages(string $showDate = 'today', string $timezone = 'UTC', string $transportType = ''): array
    {
        if (empty($transportType))
            return [];
        return $this->getMatchingMessages('Transport',  $transportType, $showDate, $timezone, 'students');
    }

    /**
     * getTransportMessages
     * @param string $showDate
     * @param string $timezone
     * @param string $transportType
     * @return array
     * @throws \Exception
     */
    public function getTransportStaffMessages(string $showDate = 'today', string $timezone = 'UTC', string $transportType = ''): array
    {
        if (empty($transportType))
            return [];
        return $this->getMatchingMessages('Transport',  $transportType, $showDate, $timezone, 'staff');
    }

    /**
     * getTransportMessages
     * @param string $showDate
     * @param string $timezone
     * @param string $transportType
     * @return array
     * @throws \Exception
     */
    public function getTransportParentMessages(string $showDate = 'today', string $timezone = 'UTC', string $transportType = ''): array
    {
        if (empty($transportType))
            return [];
        return $this->getMatchingMessages('Transport',  $transportType, $showDate, $timezone, 'parents');

        $results = array_merge($results, $this->getTransportMessages($showDate, $timezone, UserHelper::getCurrentUser()->getTransport()));
        foreach(UserHelper::getChildrenOfParent() as $child)
            $results = array_merge($results, $this->getTransportStudentMessages($showDate, $timezone, $child->getTransport()));

        return $results;
    }

    /**
     * getGroupStaffMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getGroupStaffMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $groups = UserHelper::getGroups( null, 'id');
        return $this->getMatchingMessages('Group', $groups, $showDate, $timezone, 'staff');
    }

    /**
     * getGroupStudentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getGroupStudentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $groups = UserHelper::getGroups( null, 'id');
        return $this->getMatchingMessages('Group', $groups, $showDate, $timezone, 'staff');
    }

    /**
     * getGroupStudentMessages
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getGroupParentMessages(string $showDate = 'today', string $timezone = 'UTC'): array
    {
        $groups = UserHelper::getGroups( null, 'id');

        $results = $this->getMatchingMessages('Group', $groups, $showDate, $timezone, 'parents');
        foreach(UserHelper::getChildrenOfParent() as $child){
            $groups = UserHelper::getGroups($child, 'id');
            $results = array_merge($results, $this->getMatchingMessages('Group', $groups, $showDate, $timezone, 'parents'));
        }
        return $results;
    }
}