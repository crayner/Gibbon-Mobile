<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 * (c) 2019 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 5/04/2019
 * Time: 10:40
 */
namespace App\Manager;

use App\Entity\Person;
use App\Provider\PersonProvider;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ImpersonationManager
 * @package App\Manager
 */
class ImpersonationManager
{
    /**
     * @var PersonProvider 
     */
    private $provider;

    /**
     * ImpersonationManager constructor.
     * @param PersonProvider $provider
     * @throws \Exception
     */
    public function __construct(PersonProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * getProvider
     * @return PersonProvider
     */
    public function getProvider(): PersonProvider
    {
        return $this->provider;
    }

    /**
     * @var Person|null
     */
    private $student;

    /**
     * getStudent
     * @return Person|null
     */
    public function getStudent(): ?Person
    {
        return $this->student;
    }

    /**
     * setPerson
     * @param Person|null $student
     * @return ImpersonationManager
     */
    public function setStudent(?Person $student): ImpersonationManager
    {
        $this->clearPerson(false);
        $this->student = $student;
        return $this;
    }

    /**
     * @var Person|null
     */
    private $parent;

    /**
     * getParent
     * @return Person|null
     */
    public function getParent(): ?Person
    {
        return $this->parent;
    }

    /**
     * setPerson
     * @param Person|null $parent
     * @return ImpersonationManager
     */
    public function setParent(?Person $parent): ImpersonationManager
    {
        $this->clearPerson(false);
        $this->parent = $parent;
        return $this;
    }

    /**
     * @var Person|null
     */
    private $staff;

    /**
     * getStaff
     * @return Person|null
     */
    public function getStaff(): ?Person
    {
        return $this->staff;
    }

    /**
     * setPerson
     * @param Person|null $staff
     * @return ImpersonationManager
     */
    public function setStaff(?Person $staff): ImpersonationManager
    {
        $this->clearPerson(false);
        $this->staff = $staff;
        return $this;
    }

    /**
     * clearPerson
     * @param bool $clear
     * @return ImpersonationManager
     */
    private function clearPerson(bool $clear = true): ImpersonationManager
    {
        if (!$clear)
            return $this;
        $this->setStudent(null);
        $this->setStaff(null);
        $this->setParent(null);
        return $this;
    }

    /**
     * getPerson
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        if ($this->getStudent() instanceof Person)
            return $this->getStudent();
        if ($this->getStaff() instanceof Person)
            return $this->getStaff();
        return $this->getParent();
    }
}