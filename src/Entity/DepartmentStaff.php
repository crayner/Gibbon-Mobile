<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DepartmentStaff
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentStaffRepository")
 * @ORM\Table(name="DepartmentStaff")
 */
class DepartmentStaff
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="smallint", name="gibbonDepartmentStaffID", columnDefinition="INT(6) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Department|null
     * @ORM\ManyToOne(targetEntity="Department")
     * @ORM\JoinColumn(name="gibbonDepartmentID", referencedColumnName="gibbonDepartmentID", nullable=false)
     */
    private $department;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;


    /**
     * @var string|null
     * @ORM\Column(length=24)
     */
    private $role;

    /**
     * @var array
     */
    private static $roleList = ['Coordinator','Assistant Coordinator','Teacher (Curriculum)','Teacher','Director','Manager','Administrator','Other'];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return DepartmentStaff
     */
    public function setId(?int $id): DepartmentStaff
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Department|null
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    /**
     * @param Department|null $department
     * @return DepartmentStaff
     */
    public function setDepartment(?Department $department): DepartmentStaff
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * @param Person|null $person
     * @return DepartmentStaff
     */
    public function setPerson(?Person $person): DepartmentStaff
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string|null $role
     * @return DepartmentStaff
     */
    public function setRole(?string $role): DepartmentStaff
    {
        $this->role = in_array($role, self::getRoleList()) ? $role : '';
        return $this;
    }

    /**
     * @return array
     */
    public static function getRoleList(): array
    {
        return self::$roleList;
    }
}