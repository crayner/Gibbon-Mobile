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
 * Class Rubric
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RubricRepository")
 * @ORM\Table(name="Rubric")
 */
class Rubric
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonRubricID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $name;

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
    private $active;

    /**
     * @var string|null
     * @ORM\Column(length=10)
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
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleID", referencedColumnName="gibbonScaleID")
     */
    private $scale;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $creator;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Rubric
     */
    public function setId(?int $id): Rubric
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
     * @return Rubric
     */
    public function setName(?string $name): Rubric
    {
        $this->name = $name;
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
     * @return Rubric
     */
    public function setCategory(?string $category): Rubric
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
     * @return Rubric
     */
    public function setDescription(?string $description): Rubric
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
     * @return Rubric
     */
    public function setActive(?string $active): Rubric
    {
        $this->active = $active;
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
     * @return Rubric
     */
    public function setScope(?string $scope): Rubric
    {
        $this->scope = in_array($scope, self::getScopeList()) ? $scope : '';
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
     * @return Rubric
     */
    public function setDepartment(?Department $department): Rubric
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
     * @return Rubric
     */
    public function setYearGroupList(?string $yearGroupList): Rubric
    {
        $this->yearGroupList = $yearGroupList;
        return $this;
    }

    /**
     * @return Scale|null
     */
    public function getScale(): ?Scale
    {
        return $this->scale;
    }

    /**
     * @param Scale|null $scale
     * @return Rubric
     */
    public function setScale(?Scale $scale): Rubric
    {
        $this->scale = $scale;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getCreator(): ?Person
    {
        return $this->creator;
    }

    /**
     * @param Person|null $creator
     * @return Rubric
     */
    public function setCreator(?Person $creator): Rubric
    {
        $this->creator = $creator;
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