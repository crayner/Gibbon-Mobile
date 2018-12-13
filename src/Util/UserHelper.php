<?php
/**
 * Created by PhpStorm.
 *
 * This file is part of the Busybee Project.
 *
 * (c) Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * UserProvider: craig
 * Date: 13/06/2018
 * Time: 16:27
 */
namespace App\Util;

use App\Entity\Person;
use App\Provider\PersonProvider;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserHelper
{
    /**
     * @var TokenStorageInterface
     */
    private static $tokenStorage;

    /**
     * @var PersonProvider
     */
    private static $provider;

    /**
     * UserHelper constructor.
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage, PersonProvider $provider)
    {
        self::$tokenStorage = $tokenStorage;
        self::$provider = $provider;
    }

    /**
     * @var UserInterface|null
     */
    private static $currentUser;

    /**
     * getCurrentUser
     * @return UserInterface|null
     */
    public static function getCurrentUser(): ?UserInterface
    {
        if (! is_null(self::$currentUser))
            return self::$currentUser;

        if (empty(self::$tokenStorage))
            return null;

        $token = self::$tokenStorage->getToken();

        if (is_null($token))
            return null;

        $user = $token->getUser();
        if ($user instanceof Person)
            self::$currentUser = $user;
        else
            self::$currentUser = null;

        return self::$currentUser;
    }

    /**
     * getProvider
     * @return PersonProvider
     */
    public static function getProvider(): PersonProvider
    {
        return self::$provider;
    }

    /**
     * isStaff
     * @return bool
     */
    public static function isStaff(): bool
    {
        self::$provider->setEntity(self::getCurrentUser());
        return self::$provider->isStaff();
    }

    /**
     * isParent
     * @return bool
     */
    public static function isStudent(): bool
    {
        self::$provider->setEntity(self::getCurrentUser());
        return self::$provider->isStudent();
    }

    /**
     * isParent
     * @return bool
     */
    public static function isParent(): bool
    {
        self::$provider->setEntity(self::getCurrentUser());
        return self::$provider->isParent();
    }

    /**
     * getRoles
     * @return array
     * @throws \Exception
     */
    public static function getRoles(): array
    {
        self::$provider->setEntity(self::getCurrentUser());
        return self::$provider->getUserRoles();
    }

    /**
     * getRoleCategories
     * @return array
     * @throws \Exception
     */
    public static function getRoleCategories(): array
    {
        self::$provider->setEntity(self::getCurrentUser());
        return self::$provider->getUserRoleCategories();
    }

    /**
     * @var array
     */
    private static $staffYearGroupsByCourse;

    /**
     * getYearGroups
     * @return array
     * @throws \Exception
     */
    public static function getStaffYearGroupsByCourse(): array
    {
        if (! empty(self::$staffYearGroupsByCourse))
            return self::$staffYearGroupsByCourse;
        self::$provider->setEntity(self::getCurrentUser());
        return self::$provider->getStaffYearGroupsByCourse();
    }

    /**
     * @var array
     */
    private static $staffYearGroupsByRollGroup;

    /**
     * getYearGroups
     * @return array
     * @throws \Exception
     */
    public static function getStaffYearGroupsByRollGroup(): array
    {
        if (! empty(self::$staffYearGroupsByRollGroup))
            return self::$staffYearGroupsByRollGroup;
        self::$provider->setEntity(self::getCurrentUser());
        return self::$provider->getStaffYearGroupsByRollGroup();
    }

    /**
     * getYearGroups
     * @return array
     * @throws \Exception
     */
    public static function getStudentYearGroup(): array
    {
        self::$provider->setEntity(self::getCurrentUser());
        return self::$provider->getStudentYearGroup();
    }

    /**
     * getYearGroups
     * @return array
     * @throws \Exception
     */
    public static function getParentYearGroups(): array
    {
        self::$provider->setEntity(self::getCurrentUser());
        return self::$provider->getParentYearGroups();
    }

    /**
     * @var array
     */
    private static $childrenOfParent;

    /**
     * getChildrenOfParent
     * @return array
     * @throws \Exception
     */
    public static function getChildrenOfParent(): array
    {
        if (! empty(self::$childrenOfParent))
            return self::$childrenOfParent;
        self::$provider->setEntity(self::getCurrentUser());
        return self::$childrenOfParent = self::$provider->getChildrenOfParent();
    }

    /**
     * getStaffRollGroups
     * @param string $returnStyle
     * @return array
     */
    public static function getStaffRollGroups(string $returnStyle = 'entity'): array
    {
        $x = self::getProvider()->getStaffRollGroups();
        if ($returnStyle === 'entity')
            return $x;
        $result = [];
        foreach($x as $item)
            $result[] = $item->getId();
        return array_unique($result);
    }

    /**
     * getStaffRollGroups
     * @param string $returnStyle
     * @return array
     */
    public static function getStudentRollGroups(string $returnStyle = 'entity'): array
    {
        $x = self::getProvider()->getStudentRollGroups();
        if ($returnStyle === 'entity')
            return $x;
        $result = [];
        foreach($x as $item)
            $result[] = $item->getId();
        return array_unique($result);
    }

    /**
     * getParentRollGroups
     * @param string $returnStyle
     * @return array
     */
    public static function getParentRollGroups(string $returnStyle = 'entity'): array
    {
        $x = self::getProvider()->getParentRollGroups();
        if ($returnStyle === 'entity')
            return $x;
        $result = [];
        foreach($x as $item)
            $result[] = $item->getId();
        return array_unique($result);
    }

    /**
     * getPersonCourses
     * @param string $returnStyle
     * @return array
     * @throws \Exception
     */
    public static function getCoursesByPerson(?Person $person = null, string $returnStyle = 'entity')
    {
        $person = $person ?: self::getCurrentUser();
        self::getProvider()->setEntity($person);

        $x = self::getProvider()->getCoursesByPerson();
        if ($returnStyle === 'entity')
            return $x;
        $result = [];
        foreach($x as $item)
            $result[] = $item->getId();
        return array_unique($result);
    }

    /**
     * getPersonCourses
     * @param string $returnStyle
     * @return array
     * @throws \Exception
     */
    public static function getCourseClassesByPerson(?Person $person = null, string $returnStyle = 'entity')
    {
        $person = $person ?: self::getCurrentUser();
        self::getProvider()->setEntity($person);

        $x = self::getProvider()->getCourseClassesByPerson();
        if ($returnStyle === 'entity')
            return $x;
        $result = [];
        foreach($x as $item)
            $result[] = $item->getId();
        return array_unique($result);
    }

    /**
     * getActivitiesByStaff
     * @param string $returnStyle
     * @return array
     * @throws \Exception
     */
    public static function getActivitiesByStaff(string $returnStyle = 'entity')
    {
        $x = self::getProvider()->getActivitiesByStaff();
        if ($returnStyle === 'entity')
            return $x;
        $result = [];
        foreach($x as $item)
            $result[] = $item->getId();
        return array_unique($result);
    }

    /**
     * getActivitiesByStudents
     * @param string $returnStyle
     * @return array
     * @throws \Exception
     */
    public static function getActivitiesByStudent(?Person $person = null, string $returnStyle = 'entity')
    {
        self::getProvider()->setEntity($person ?: self::getCurrentUser());
        if (! self::getProvider()->getEntity()->isStudent())
            return [];
        $x = self::getProvider()->getActivitiesByStudents();
        if ($returnStyle === 'entity')
            return $x;
        $result = [];
        foreach($x as $item)
            $result[] = $item->getId();
        return array_unique($result);
    }

    /**
     * getActivitiesByParent
     * @param string $returnStyle
     * @return array
     * @throws \Exception
     */
    public static function getActivitiesByParent(string $returnStyle = 'entity'): array
    {
        if (!self::getCurrentUser()->isParent())
            return [];
        $x = self::getProvider()->getActivitiesByParent();
        if ($returnStyle === 'entity')
            return $x;
        $result = [];
        foreach($x as $item)
            $result[] = $item->getId();
        return array_unique($result);
    }

    /**
     * getStudentAttendance
     * @param string $showDate
     * @param Person|null $person
     * @param string $returnStyle
     * @return array
     */
    public static function getStudentAttendance(string $showDate = 'today', string $timezone = 'UTC', ?Person $person = null, string $returnStyle = 'entity'): array
    {
        $person = $person ?: self::getCurrentUser();
        if (!$person->isStudent())
            return [];
        self::getProvider()->setEntity($person);
        $x = self::getProvider()->getStudentAttendance($showDate, $timezone);
        if ($returnStyle === 'entity')
            return $x;
        $result = [];
        foreach($x as $item)
            $result[] = $item->getId();
        return array_unique($result);
    }
}