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
class PersonProvider extends UserProvider
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
        return $this->getRepository(Course::class)->createQueryBuilder('c')
            ->select('DISTINCT c')
            ->leftJoin('c.courseClasses', 'cc')
            ->leftJoin('cc.courseClassPeople', 'ccp')
            ->where('ccp.person = :person')
            ->setParameter('person', $this->getEntity())
            ->andWhere('c.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
    }

    /**
     * getCourseClassesByPerson
     * @return array
     * @throws \Exception
     */
    public function getCourseClassesByPerson(): array
    {
        return $this->getRepository(CourseClass::class)->createQueryBuilder('cc')
            ->select('DISTINCT cc')
            ->leftJoin('cc.courseClassPeople', 'ccp')
            ->leftJoin('cc.course', 'c')
            ->where('ccp.person = :person')
            ->setParameter('person', $this->getEntity())
            ->andWhere('c.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
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
     * getStaffYearGroupsByRollGroup
     * @return array
     * @throws \Exception
     */
    public function getStaffYearGroupsByRollGroup(): array
    {
        $x = $this->getRepository(StudentEnrolment::class)->createQueryBuilder('se')
            ->select('DISTINCT yg.id AS yearGroupList')
            ->leftJoin('se.yearGroup', 'yg')
            ->leftJoin('se.rollGroup', 'rg')
            ->where('rg.tutor = :person OR rg.tutor2 = :person OR rg.tutor3 = :person')
            ->setParameter('person', $this->getEntity())
            ->andWhere('se.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
        $results = [];
        foreach($x as $list)
            $results = array_merge($results, [str_pad($list['yearGroupList'],3, '0', STR_PAD_LEFT)]);

        return array_unique($results);
    }

    /**
     * getStaffYearGroupsByRollGroup
     * @return array
     * @throws \Exception
     */
    public function getStudentYearGroup(?Person $person = null): array
    {
        $person = $person ?: UserHelper::getCurrentUser();
        $x = $this->getRepository(StudentEnrolment::class)->createQueryBuilder('se')
            ->select('DISTINCT yg.id AS yearGroupList')
            ->leftJoin('se.yearGroup', 'yg')
            ->where('se.schoolYear = :schoolYear')
            ->andWhere('se.person = :person')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->setParameter('person', $person)
            ->getQuery()
            ->getResult();
        $results = [];
        foreach($x as $list)
            $results = array_merge($results, explode(',',$list['yearGroupList']));

        return array_unique($results);
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
     * @param Person|null $person
     * @return array
     * @throws \Exception
     */
    public function getChildrenOfParent(): array
    {
        $x = $this->getRepository(FamilyAdult::class)->createQueryBuilder('fa')
            ->leftJoin('fa.family', 'f')
            ->leftJoin('f.children', 'fc')
            ->leftJoin('fc.person', 'p')
            ->select('fa,f,fc,p')
            ->where('fa.person = :person')
            ->setParameter('person', UserHelper::getCurrentUser())
            ->getQuery()
            ->getResult();
        $results = [];
        foreach(($x ?: []) as $item) {
            foreach($item->getFamily()->getChildren() as $child)
                if ($child->getPerson())
                    $results[$child->getPerson()->getId()] = $child->getPerson();
        }
        return $results;
    }

    /**
     * getStaffRollGroups
     * @return array
     */
    public function getStaffRollGroups(): array
    {
        return $this->getRepository(RollGroup::class)->createQueryBuilder('rg')
            ->select('rg')
            ->where('rg.tutor = :person OR rg.tutor2 = :person OR rg.tutor3 = :person OR rg.assistant = :person OR rg.assistant2 = :person OR rg.assistant3 = :person')
            ->setParameter('person', UserHelper::getCurrentUser())
            ->andWhere('rg.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
    }

    /**
     * getStudentRollGroups
     * @return array
     * @throws \Exception
     */
    public function getStudentRollGroups(?Person $person = null): array
    {
        $person = $person ?: UserHelper::getCurrentUser();
        return $this->getRepository(RollGroup::class)->createQueryBuilder('rg')
            ->select('rg')
            ->leftJoin('rg.studentEnrolments', 'se')
            ->where('se.person = :person')
            ->setParameter('person', $person)
            ->andWhere('rg.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
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
        return $this->getRepository(Activity::class)->createQueryBuilder('a')
            ->select('DISTINCT a')
            ->leftJoin('a.staff', 'a_s')
            ->where('a_s.person = :person')
            ->setParameter('person', UserHelper::getCurrentUser())
            ->andWhere('a.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
    }

    /**
     * getActivitiesByStudents
     * @return array
     * @throws \Exception
     */
    public function getActivitiesByStudents(): array
    {
        return $this->getRepository(Activity::class)->createQueryBuilder('a')
            ->select('DISTINCT a')
            ->leftJoin('a.students', 'a_s')
            ->where('a_s.person = :person')
            ->setParameter('person', $this->getEntity())
            ->andWhere('a.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
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
     * @return array
     * @throws \Exception
     */
    public function getStudentAttendance(string $showDate, string $timezone): array
    {
        $showDate = new \DateTime($showDate, new \DateTimeZone($timezone));
        $showDate = $showDate->format('Y-m-d');
        return $this->getRepository(AttendanceLogPerson::class)->createQueryBuilder('alp')
            ->leftJoin('alp.studentEnrolment', 'se', 'WITH', 'alp.person = se.person')
            ->where('alp.person = :person')
            ->setParameter('person', $this->getEntity())
            ->andWhere('alp.date = :showDate')
            ->setParameter('showDate', $showDate)
            ->getQuery()
            ->getResult();
    }

    /**
     * getStudentAttendance
     * @param string $showDate
     * @return array
     * @throws \Exception
     */
    public function getGroups(): array
    {
        return $this->getRepository(Group::class)->createQueryBuilder('g')
            ->leftJoin('g.people', 'gp')
            ->where('gp.person = :person')
            ->setParameter('person', $this->getEntity())
            ->andWhere('g.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
    }
}