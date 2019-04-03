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

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Outcome
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\OutcomeRepository")
 * @ORM\Table(name="Outcome")
 * */
class Outcome
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonOutcomeID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=14, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $category;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $active = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $scope;

    /**
     * @var array
     */
    private static $scopeList = ['School', 'Learning Area'];

    /**
     * @var Department|null
     * @ORM\ManyToOne(targetEntity="Department")
     * @ORM\JoinColumn(name="gibbonDepartmentID", referencedColumnName="gibbonDepartmentID")
     */
    private $department;

    /**
     * @var string|null
     * @ORM\Column(name="gibbonYearGroupIDList")
     */
    private $yearGroupList;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personCreator;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Outcome
     */
    public function setId(?int $id): Outcome
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Outcome
     */
    public function setName(?string $name): Outcome
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameShort(): ?string
    {
        return $this->nameShort;
    }

    /**
     * @param string|null $nameShort
     * @return Outcome
     */
    public function setNameShort(?string $nameShort): Outcome
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return Outcome
     */
    public function setCategory(?string $category): Outcome
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Outcome
     */
    public function setDescription(?string $description): Outcome
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * @param string|null $active
     * @return Outcome
     */
    public function setActive(?string $active): Outcome
    {
        $this->active = self::checkBoolean($active, 'N');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * @param string|null $scope
     * @return Outcome
     */
    public function setScope(?string $scope): Outcome
    {
        $this->scope = in_array($scope, self::getScopeList()) ? $scope : null;
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
     * @return Outcome
     */
    public function setDepartment(?Department $department): Outcome
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getYearGroupList(): ?string
    {
        return $this->yearGroupList;
    }

    /**
     * @param string|null $yearGroupList
     * @return Outcome
     */
    public function setYearGroupList(?string $yearGroupList): Outcome
    {
        $this->yearGroupList = $yearGroupList;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonCreator(): ?Person
    {
        return $this->personCreator;
    }

    /**
     * @param Person|null $personCreator
     * @return Outcome
     */
    public function setPersonCreator(?Person $personCreator): Outcome
    {
        $this->personCreator = $personCreator;
        return $this;
    }

    /**
     * @return array
     */
    public static function getScopeList(): array
    {
        return self::$scopeList;
    }
}