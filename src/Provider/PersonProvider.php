<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 7/12/2018
 * Time: 13:39
 */
namespace App\Provider;

use App\Entity\Activity;
use App\Entity\AttendanceLogPerson;
use App\Entity\Course;
use App\Entity\CourseClass;
use App\Entity\FamilyAdult;
use App\Entity\Group;
use App\Entity\Person;
use App\Entity\Role;
use App\Entity\RollGroup;
use App\Entity\StudentEnrolment;
use App\Manager\Traits\EntityTrait;
use App\Util\SchoolYearHelper;
use App\Util\UserHelper;

/**
 * Class PersonProvider
 * @package App\Manager\Provider
 */
class PersonProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Person::class;

    /**
     * isStaff
     * @return bool
     * @throws \Exception
     */
    public function isStaff(): bool
    {
        foreach($this->getUserRoles() as $role)
            if ($role->getCategory() === 'Staff')
                return true;
        return false;
    }

    /**
     * isStudent
     * @return bool
     * @throws \Exception
     */
    public function isStudent(): bool
    {
        foreach($this->getUserRoles() as $role)
            if ($role->getCategory() === 'Student')
                return true;
        return false;
    }

    /**
     * isParent
     * @return bool
     * @throws \Exception
     */
    public function isParent(): bool
    {
        foreach($this->getUserRoles() as $role)
            if ($role->getCategory() === 'Parent')
                return true;
        return false;
    }

    /**
     * @var array
     */
    private $userRoles = [];

    /**
     * getUserRoles
     * @return array
     * @throws \Exception
     */
    public function getUserRoles(): array
    {
        if (empty($this->userRole))
            return $this->userRoles = $this->getRepository(Role::class)->findUserRoles($this->getEntity());
        return $this->userRoles;
    }

    /**
     * getUserRoles
     * @return array
     * @throws \Exception
     */
    public function getUserRoleCategories(): array
    {
        $categories = [];
        foreach($this->getUserRoles() as $role)
            if (! in_array($role->getCategory(), $categories))
                $categories[] = $role->getCategory();
        return $categories;
    }

    /**
     * getCourseByPerson
     * @return array
     * @throws \Exception
     */
    public function getCoursesByPerson(): array
    {
        return $this->getRepository(Course::class)->findByPerson($this->getEntity());
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getCourseClassesByPerson(): array
    {
        return $this->getRepository(CourseClass::class)->findByPerson($this->getEntity());
    }

    /**
     * getStaffYearGroupsByCourse
     * @return array
     * @throws \Exception
     */
    public function getStaffYearGroupsByCourse(): array
    {
        $x = UserHelper::getCoursesByPerson();
        $results = [];
        foreach($x as $list)
            $results = array_merge($results, explode(',', $list->getYearGroupList()));

        return array_unique($results);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getStaffYearGroupsByRollGroup(): array
    {
        return $this->getRepository(StudentEnrolment::class)->findStaffYearGroupsByRollGroup($this->getEntity());
    }

    /**
     * getStaffYearGroupsByRollGroup
     * @return array
     * @throws \Exception
     */
    public function getStudentYearGroup(?Person $person = null): array
    {
        $person = $person ?: UserHelper::getCurrentUser();
        return $this->getRepository(StudentEnrolment::class)->findStudentYearGroup($person);
    }

    /**
     * getParentYearGroups
     * @return array
     * @throws \Exception
     */
    public function getParentYearGroups(): array
    {
        $children = UserHelper::getChildrenOfParent();

        $yearGroups = [];
        foreach($children as $child)
            $yearGroups[] = $this->getStudentYearGroup($child);

        return array_unique($yearGroups);
    }

    /**
     * getChildrenOfParent
     * @return array
     * @throws \Exception
     */
    public function getChildrenOfParent(): array
    {
        return $this->getRepository(FamilyAdult::class)->findChildrenOfParent(UserHelper::getCurrentUser());
    }

    /**
     * getStaffRollGroups
     * @return array
     * @throws \Exception
     */
    public function getStaffRollGroups(): array
    {
        return $this->getRepository(RollGroup::class)->findByTutor(UserHelper::getCurrentUser());
    }

    /**
     * getStudentRollGroups
     * @return array
     * @throws \Exception
     */
    public function getStudentRollGroups(?Person $person = null): array
    {
        $person = $person ?: UserHelper::getCurrentUser();
        return $this->getRepository(RollGroup::class)->findByStudent($person);
    }

    /**
     * getParentRollGroups
     * @return array
     * @throws \Exception
     */
    public function getParentRollGroups(): array
    {
        $children = UserHelper::getChildrenOfParent();

        $rollGroups = [];
        foreach($children as $child)
            $rollGroups[] = $this->getStudentRollGroups($child);

        return array_unique($rollGroups);
    }

    /**
     * getActivitiesByStaff
     * @return array
     * @throws \Exception
     */
    public function getActivitiesByStaff(): array
    {
        return $this->getRepository(Activity::class)->findByStaff(UserHelper::getCurrentUser());
    }

    /**
     * getActivitiesByStudents
     * @return array
     * @throws \Exception
     */
    public function getActivitiesByStudents(): array
    {
        return $this->getRepository(Activity::class)->findByStudent($this->getEntity());
    }

    /**
     * getActivitiesByParent
     * @return array
     * @throws \Exception
     */
    public function getActivitiesByParent(): array
    {
        $children = UserHelper::getChildrenOfParent();

        $rollGroups = [];
        foreach ($children as $child)
            $rollGroups = array_merge($rollGroups, UserHelper::getActivitiesByStudents($child, 'id'));

        return array_unique($rollGroups);
    }

    /**
     * getStudentAttendance
     * @param string $showDate
     * @param string $timezone
     * @return array
     * @throws \Exception
     */
    public function getStudentAttendance(string $showDate, string $timezone): array
    {
        $showDate = new \DateTime($showDate, new \DateTimeZone($timezone));
        $showDate = $showDate->format('Y-m-d');
        return $this->getRepository(AttendanceLogPerson::class)->findByDateStudent($this->getEntity(), $showDate);
    }

    /**
     * getStudentAttendance
     * @param string $showDate
     * @return array
     * @throws \Exception
     */
    public function getGroups(): array
    {
        return $this->getRepository(Group::class)->findByPerson($this->getEntity());
    }
}