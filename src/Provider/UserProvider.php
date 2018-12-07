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
 * Time: 13:35
 */
namespace App\Provider;

use App\Entity\Person;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserProvider
 * @package App\Manager
 */
abstract class UserProvider implements UserProviderInterface
{
    /**
     * @var Person|null
     */
    private $user;

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username): UserInterface
    {
        if ($this->getUser() instanceof Person)
            return $this->getUser();
        $this->setUser($this->getRepository()->loadUserByUsername($username));
        if ($this->getUser() instanceof Person)
            return $this->getUser();

        throw new UsernameNotFoundException(sprintf('The user "%s" was not found.', $username));
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException  if the user is not supported
     * @throws UsernameNotFoundException if the user is not found
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if ($this->supportsClass(get_class($user)) && $this->getUser() && $this->getUser()->isEqualTo($user))
            return $this->getUser();
        if (! $this->supportsClass(get_class($user)))
            throw new UnsupportedUserException(sprintf('The '));
        if ($user instanceof UserInterface)
            $this->loadUserByUsername($user->getUsername());
        if ($user->isEqualTo($this->getUser()))
            $this->refresh = $user->getId();
        return $this->getUser();
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class): bool
    {
        if ($class === Person::class)
            return true;
        return false;
    }

    /**
     * @return Person|null
     */
    public function getUser(): ?Person
    {
        return $this->user;
    }

    /**
     * @param Person|null $user
     * @return UserProvider
     */
    public function setUser(?Person $user): UserProvider
    {
        $this->user = $user;
        return $this;
    }
}