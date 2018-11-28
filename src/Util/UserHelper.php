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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserHelper
{
    /**
     * @var TokenStorageInterface
     */
    private static $tokenStorage;


    /**
     * UserHelper constructor.
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        self::$tokenStorage = $tokenStorage;
    }

    /**
     * @var UserInterface|null
     */
    private static $currentUser;

    /**
     * getCurrentUser
     *
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
}