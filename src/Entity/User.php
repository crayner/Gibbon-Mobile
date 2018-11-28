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
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Entity;

use App\Util\EntityHelper;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class User
 * @package App\Entity
 */
abstract class User implements UserInterface, EncoderAwareInterface
{
    /**
     * @var array
     */
    private $roles = [];

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles(): array
    {
        if (!empty($this->roles))
            return $this->roles;
        $roles[] = $this->getMappedRole($this->getPrimaryRole());
        if ($this->isSystemAdmin())
            $roles[] = 'ROLE_SYSTEM_ADMIN';
        foreach($this->getAllRolesAsArray() as $role)
                $roles[] = $this->getMappedRole($role);
        return $this->roles = array_unique($roles);
    }

    /**
     * getAllRolesAsArray
     * @return array
     */
    public function getAllRolesAsArray(): array
    {
        $roleIDs = $this->getAllRoles() ? explode(',', $this->getAllRoles()) : [];
        $roles = [];
        foreach($roleIDs as $roleID)
            $roles[] = EntityHelper::getRepository(Role::class)->find($roleID);
        return $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        if (! empty($this->getMD5Password()))
            $x = $this->getMD5Password() ;
        else
            $x =  empty($this->getPasswordStrong()) ? null : $this->getPasswordStrong();
        return $x;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function setPassword($password)
    {
        $this->setPasswordStrong($password);
        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        $salt = $this && ! empty($this->getPasswordStrongSalt()) ? $this->getPasswordStrongSalt() : null ;
        return $salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this && ! empty($this->getUsername()) ? $this->getUsername() : null ;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Gets the name of the encoder used to encode the password.
     *
     * If the method returns null, the standard way to retrieve the encoder
     * will be used instead.
     *
     * @return string
     */
    public function getEncoderName(): string
    {
        if (! empty($this->getMD5Password()))
            return 'md5';
        return 'sha256';
    }

    /**
     * isAccountNonLocked
     * @return bool
     */
    public function isAccountNonLocked(): bool
    {
        if ($this->getFailCount() >= 3) {
            $now = new DateTime('now');
            if (abs($now->getTimestamp() - $this->getLastFailTimestamp()->getTimestamp()) > 1200)
                return true;
            return false;
        }
        return true;
    }

    /**
     * isEnabled
     * @return bool
     */
    public function isEnabled(): Boolean
    {
        if ($this->getPrimaryRole()->getCanRoleLogin() === 'N')
            return false;

        return $this->getCanLogin() === 'N' ? false : true ;
    }

    /**
     * isAccountNonExpired
     * @return bool
     */
    public function isAccountNonExpired(): bool
    {
        return true;
    }

    /**
     * isCredentialsNonExpired
     * @return bool
     */
    public function isCredentialsNonExpired(): bool
    {
        return true;
    }

    /**
     * getLocale
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return $this->getI18nPersonal();
    }

    /**
     * getMappedRole
     * @param Role $role
     * @return string
     */
    private function getMappedRole(Role $role): string
    {
        switch ($role->getNameShort()) {
            case 'Adm':
                return 'ROLE_ADMIN';
            case 'Tcr':
                return 'ROLE_TEACHER';
            case 'Std':
                return 'ROLE_STUDENT';
            case 'Prt':
                return 'ROLE_PARENT';
            case 'SSt':
                return 'ROLE_STAFF';
            default:
                return 'ROLE_USER';
        }
    }
}