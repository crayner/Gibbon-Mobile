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

use App\Manager\EntityInterface;
use App\Manager\Traits\BooleanList;
use App\Util\EntityHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class Course
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 * @ORM\Table(name="Course", indexes={@ORM\Index(name="gibbonSchoolYearID", columns={"gibbonSchoolYearID"})}, uniqueConstraints={@ORM\UniqueConstraint(name="nameYear",columns={ "gibbonSchoolYearID", "name"})})
 */
class Course implements EntityInterface
{
    use BooleanList;
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonCourseID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=false)
     */
    private $schoolYear;

    /**
     * @var Department|null
     * @ORM\ManyToOne(targetEntity="Department")
     * @ORM\JoinColumn(name="gibbonDepartmentID", referencedColumnName="gibbonDepartmentID")
     */
    private $department;

    /**
     * @var string|null
     * @ORM\Column(length=60)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=12, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"comment": "Should this course be included in curriculum maps and other summaries?", "default": "Y"})
     */
    private $map = 'Y';

    /**
     * @var string|null
     * @ORM\Column(name="gibbonYearGroupIDList")
     */
    private $yearGroupList;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="orderBy", columnDefinition="INT(3)")
     */
    private $orderBy;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Entity\CourseClass", mappedBy="course")
     */
    private $courseClasses;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Course
     */
    public function setId(?int $id): Course
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return SchoolYear|null
     */
    public function getSchoolYear(): ?SchoolYear
    {
        return $this->schoolYear;
    }

    /**
     * @param SchoolYear|null $schoolYear
     * @return Course
     */
    public function setSchoolYear(?SchoolYear $schoolYear): Course
    {
        $this->schoolYear = $schoolYear;
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
     * @return Course
     */
    public function setDepartment(?Department $department): Course
    {
        $this->department = $department;
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
     * @return Course
     */
    public function setName(?string $name): Course
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
     * @return Course
     */
    public function setNameShort(?string $nameShort): Course
    {
        $this->nameShort = $nameShort;
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
     * @return Course
     */
    public function setDescription(?string $description): Course
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMap(): ?string
    {
        return $this->map;
    }

    /**
     * @param string|null $map
     * @return Course
     */
    public function setMap(?string $map): Course
    {
        $this->map = self::checkBoolean($map, 'Y');
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
     * @return Course
     */
    public function setYearGroupList(?string $yearGroupList): Course
    {
        $this->yearGroupList = $yearGroupList;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderBy(): ?int
    {
        return $this->orderBy;
    }

    /**
     * @param int|null $orderBy
     * @return Course
     */
    public function setOrderBy(?int $orderBy): Course
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * getCourseClasses
     * @return Collection
     */
    public function getCourseClasses(): Collection
    {
        if (empty($this->courseClasses))
            $this->courseClasses = new ArrayCollection();

        if ($this->courseClasses instanceof PersistentCollection)
            $this->courseClasses->initialize();

        return $this->courseClasses;
    }

    /**
     * @param Collection|null $courseClasses
     * @return Course
     */
    public function setCourseClasses(?Collection $courseClasses): Course
    {
        $this->courseClasses = $courseClasses;
        return $this;
    }

    /**
     * __toArray
     * @param array $ignore
     * @return array
     */
    public function __toArray(array $ignore = []): array
    {
        return EntityHelper::__toArray(Course::class, $this, $ignore);
    }
}