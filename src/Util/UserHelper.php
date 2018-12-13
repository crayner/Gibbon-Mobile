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
}