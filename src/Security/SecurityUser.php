<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 12/02/2019
 * Time: 16:06
 */

namespace App\Security;

use App\Entity\Person;
use App\Entity\Role;
use App\Util\EntityHelper;
use App\Util\UserHelper;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser implements UserInterface, EncoderAwareInterface, EquatableInterface, \Serializable
{

    /**
     * SecurityUser constructor.
     * @param Person $user
     */
    public function __construct(Person $user = null)
    {
        if ($this->isUser($user))
        {
            $this->setId($user->getId());
            $this->setUserPassword($user);
            $this->setUsername($user->getUsername());
            $this->setSalt($user->getPasswordStrongSalt());
            $this->setSystemAdmin($user->isSystemAdmin());
            $this->setAllRoles($user->getAllRoles());
            $this->setPrimaryRole($user->getPrimaryRole());
            $this->setEmail($user->getEmail());
            $this->setGoogleAPIRefreshToken($user->getGoogleAPIRefreshToken());
            $this->setLocale($user->getI18nPersonal());
        }
    }

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
     * getMappedRole
     * @param Role $role
     * @return string
     */
    private function getMappedRole(Role $role = null): string
    {
        if (is_null($role)) return '';
        switch (strtoupper($role->getNameShort())) {
            case 'ADM':
                return 'ROLE_ADMIN';
            case 'TCR':
                return 'ROLE_TEACHER';
            case 'STD':
                return 'ROLE_STUDENT';
            case 'PRT':
                return 'ROLE_PARENT';
            case 'SST':
                return 'ROLE_STAFF';
            default:
                return 'ROLE_USER';
        }
    }

    /**
     * @var Role|null
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="gibbonRoleIDPrimary", referencedColumnName="gibbonRoleID", nullable=false)
     */
    private $primaryRole;

    /**
     * @return Role|null
     */
    public function getPrimaryRole(): ?Role
    {
        return $this->isUser() ? $this->getUser()->getPrimaryRole() : null;
    }

    /**
     * setPrimaryRole
     * @param Role|null $primaryRole
     * @return SecurityUser
     */
    public function setPrimaryRole(?Role $primaryRole): SecurityUser
    {
        $this->primaryRole = $primaryRole;
        if ($this->isUser()) $this->getUser()->setPrimaryRole($primaryRole);
        return $this;
    }

    /**
     * isUser
     * @param Person|null $user
     * @return bool
     */
    private function isUser(Person $user = null)
    {
        return $user instanceof Person;
    }

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var string 
     */
    private $encoderName = 'sha256';

    /**
     * setUserPassword
     * @param Person $user
     * @return SecurityUser
     */
    public function setUserPassword(Person $user): SecurityUser
    {
        if (! $this->isUser($user))
            return $this->setPassword(null);
        if (! empty($user->getMD5Password())) {
            $x = $user->getMD5Password();
            $this->setEncoderName('md5');
        } else {
            $x = empty($user->getPasswordStrong()) ? null : $user->getPasswordStrong();
            $this->setEncoderName('sha256');
        }
        return $this->setPassword($x);
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return SecurityUser
     */
    public function setPassword(?string $password): SecurityUser
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncoderName(): string
    {
        return $this->encoderName ?: 'sha256';
    }

    /**
     * @param string $encoderName
     * @return SecurityUser
     */
    public function setEncoderName(string $encoderName): SecurityUser
    {
        $this->encoderName = $encoderName;
        return $this;
    }

    /**
     * @var string|null
     */
    private $username;

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return SecurityUser
     */
    public function setUsername(?string $username): SecurityUser
    {
        $this->username = $username;
        return $this;
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
     * serialize
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->getId(),
            $this->getUsername(),
            $this->getPassword(),
            $this->getSalt(),
            $this->getEmail(),
            $this->getPrimaryRole(),
            $this->getAllRoles(),
        ));
    }

    /**
     * unserialize
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
            $this->email,
            $this->primaryRole,
            $this->allRoles,
            ) = unserialize($serialized);
    }

    /**
     * @var integer|null
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return SecurityUser
     */
    public function setId(?int $id): SecurityUser
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var string
     */
    private $salt;

    /**
     * getSalt
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt ?: '';
    }

    /**
     * setSalt
     * @param null|string $salt
     * @return SecurityUser
     */
    public function setSalt(?string $salt): SecurityUser
    {
        $this->salt = $salt ?: '';
        return $this;
    }

    /**
     * @var bool
     */
    private $systemAdmin = false;

    /**
     * @return bool
     */
    public function isSystemAdmin(): bool
    {
        return $this->systemAdmin;
    }

    /**
     * @param bool $systemAdmin
     * @return SecurityUser
     */
    public function setSystemAdmin(bool $systemAdmin): SecurityUser
    {
        $this->systemAdmin = $systemAdmin;
        return $this;
    }

    /**
     * @var string|null
     */
    private $allRoles;

    /**
     * @return string|null
     */
    public function getAllRoles(): ?string
    {
        return $this->allRoles;
    }

    /**
     * @param string|null $allRoles
     * @return SecurityUser
     */
    public function setAllRoles(?string $allRoles): SecurityUser
    {
        $this->allRoles = $allRoles;
        return $this;
    }

    /**
     * @var string|null
     */
    private $email;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return SecurityUser
     */
    public function setEmail(?string $email): SecurityUser
    {
        $this->email = $email;
        return $this;
    }

    /**
     * isEqualTo
     * @param Person $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user): bool
    {
        if ($user->getId() !== $this->getId())
            return false;
        if ($user->getUsername() !== $this->getUsername())
            return false;
        if ($user->getEmail() !== $this->getEmail())
            return false;
        if ($user->getPassword() !== $this->getPassword())
            return false;
        if ($user->getSalt() !== $this->getSalt())
            return false;
        return true;
    }

    /**
     * formatName
     * @param bool $preferredName
     * @param bool $reverse
     * @param bool $informal
     * @param bool $initial
     * @return string
     * @throws \Exception
     */
    public function formatName(bool $preferredName = true, bool $reverse = false, bool $informal = false, bool $initial = false)
    {
        return UserHelper::getCurrentUser()->formatName($preferredName, $reverse, $informal, $initial);
    }

    /**
     * @var null|string
     */
    private $googleAPIRefreshToken;

    /**
     * @return string|null
     */
    public function getGoogleAPIRefreshToken(): ?string
    {
        return $this->googleAPIRefreshToken;
    }

    /**
     * @param string|null $googleAPIRefreshToken
     * @return SecurityUser
     */
    public function setGoogleAPIRefreshToken(?string $googleAPIRefreshToken): SecurityUser
    {
        $this->googleAPIRefreshToken = $googleAPIRefreshToken;
        return $this;
    }

    /**
     * @var string
     */
    private $locale;

    /**
     * getLocale
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale ?: 'en_GB';
    }

    /**
     * @param string $locale
     * @return SecurityUser
     */
    public function setLocale(?string $locale): SecurityUser
    {
        $this->locale = $locale ?: 'en_GB';
        return $this;
    }
}