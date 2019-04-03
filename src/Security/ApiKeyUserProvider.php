<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 26/02/2019
 * Time: 17:34
 */
namespace App\Security;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    /**
     * @var SecurityUser|null
     */
    private $securityUser;

    public function getUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        $username = '';
        dd($this);

        return $username;
    }

    public function loadUserByUsername($username)
    {
        if (null === ($user = $this->getUserRepository()->loadUserByUsername($username))) {
            throw new BadCredentialsException(sprintf('No user found for "%s"', $username));
        }

        $this->setUser($user);
        // create the DTO and feed it with the entity
        $this->securityUser = new SecurityUser($user);

        return $this->getSecurityUser();
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    /**
     * supportsClass
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return SecurityUser::class === $class;
    }

    /**
     * @return SecurityUser|null
     */
    public function getSecurityUser(): ?SecurityUser
    {
        return $this->securityUser;
    }

    /**
     * setSecurityUser
     * @param SecurityUser|null $securityUser
     * @return ApiKeyUserProvider
     */
    public function setSecurityUser(?SecurityUser $securityUser): ApiKeyUserProvider
    {
        $this->securityUser = $securityUser;
        return $this;
    }

    /**
     * @var Person|null
     */
    private $user;

    /**
     * getUser
     * @return Person|null
     */
    public function getUser(): ?Person
    {
        return $this->user = $this->user ?: $this->loadUser();
    }

    /**
     * setUser
     * @param Person|null $user
     * @return ApiKeyUserProvider
     */
    public function setUser(?Person $user): ApiKeyUserProvider
    {
        $this->user = $user;
        return $this;
    }

    /**
     * loadUser
     * @return Person|null
     */
    private function loadUser(): ?Person
    {
        $person = $this->getSecurityUser() ? $this->getUserRepository()->find( $this->getSecurityUser()->getId()) : null;
        $this->setUser($person);
        return $this->user;
    }

    /**
     * @var PersonRepository|null
     */
    private $userRepository;

    /**
     * @return PersonRepository|null
     */
    public function getUserRepository(): ?PersonRepository
    {
        return $this->userRepository;
    }

    /**
     * setUserRepository
     * @param PersonRepository|null $userRepository
     * @return ApiKeyUserProvider
     */
    public function setUserRepository(?PersonRepository $userRepository): ApiKeyUserProvider
    {
        $this->userRepository = $userRepository;
        return $this;
    }

    /**
     * ApiKeyUserProvider constructor.
     * @param PersonRepository $repository
     */
    public function __construct(PersonRepository $repository)
    {
        $this->userRepository = $repository;
    }
}
