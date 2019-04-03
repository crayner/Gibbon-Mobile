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
 * Class CourseClass
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CourseClassRepository")
 * @ORM\Table(name="CourseClass", indexes={@ORM\Index(name="gibbonCourseID", columns={"gibbonCourseID"})})
 */
class CourseClass implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonCourseClassID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Course|null
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="courseClasses")
     * @ORM\JoinColumn(name="gibbonCourseID", referencedColumnName="gibbonCourseID", nullable=false)
     */
    private $course;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=8, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $reportable = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $attendance = 'Y';

    /**
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleIDTarget", referencedColumnName="gibbonScaleID")
     */
    private $scale;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Entity\CourseClassPerson", mappedBy="courseClass")
     */
    private $courseClassPeople;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="TTDayRowClass", mappedBy="courseClass")
     */
    private $TTDayRowClasses;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return CourseClass
     */
    public function setId(?int $id): CourseClass
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Course|null
     */
    public function getCourse(): ?Course
    {
        return $this->course;
    }

    /**
     * @param Course|null $course
     * @return CourseClass
     */
    public function setCourse(?Course $course): CourseClass
    {
        $this->course = $course;
        return $this;
    }

    /**
     * getName
     * @param bool $withCourse
     * @return string|null
     */
    public function getName(bool $withCourse = false): ?string
    {
        if ($withCourse)
            return $this->getCourse()->getName() . '.' . $this->name;
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return CourseClass
     */
    public function setName(?string $name): CourseClass
    {
        $this->name = $name;
        return $this;
    }

    /**
     * getNameShort
     * @param bool $withCourse
     * @return string|null
     */
    public function getNameShort(bool $withCourse = false): ?string
    {
        if ($withCourse)
            return $this->getCourse()->getNameShort() . '.' . $this->nameShort;
        return $this->nameShort;
    }

    /**
     * @param string|null $nameShort
     * @return CourseClass
     */
    public function setNameShort(?string $nameShort): CourseClass
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReportable(): ?string
    {
        return $this->reportable;
    }

    /**
     * @param string|null $reportable
     * @return CourseClass
     */
    public function setReportable(?string $reportable): CourseClass
    {
        $this->reportable = self::checkBoolean($reportable, 'Y');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttendance(): ?string
    {
        return $this->attendance;
    }

    /**
     * @param string|null $attendance
     * @return CourseClass
     */
    public function setAttendance(?string $attendance): CourseClass
    {
        $this->attendance = self::checkBoolean($attendance, 'Y');
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
     * @return CourseClass
     */
    public function setScale(?Scale $scale): CourseClass
    {
        $this->scale = $scale;
        return $this;
    }

    /**
     * getCourseClassPeople
     * @return Collection|null
     */
    public function getCourseClassPeople(): ?Collection
    {
        if (empty($this->courseClassPeople))
            $this->courseClassPeople = new ArrayCollection();

        if ($this->courseClassPeople instanceof PersistentCollection)
            $this->courseClassPeople->initialize();

        return $this->courseClassPeople;
    }

    /**
     * @param Collection|null $courseClassPeople
     * @return CourseClass
     */
    public function setCourseClassPeople(?Collection $courseClassPeople): CourseClass
    {
        $this->courseClassPeople = $courseClassPeople;
        return $this;
    }

    /**
     * getTTDayRowClasses
     * @return Collection|null
     */
    public function getTTDayRowClasses(): ?Collection
    {
        if (empty($this->TTDayRowClasses))
            $this->TTDayRowClasses = new ArrayCollection();

        if ($this->TTDayRowClasses instanceof PersistentCollection)
            $this->TTDayRowClasses-> initialize();

        return $this->TTDayRowClasses;
    }

    /**
     * @param Collection|null $TTDayRowClasses
     * @return CourseClass
     */
    public function setTTDayRowClasses(?Collection $TTDayRowClasses): CourseClass
    {
        $this->TTDayRowClasses = $TTDayRowClasses;
        return $this;
    }

    /**
     * @var Collection
     */
    private $students;

    /**
     * getStudents
     * @return Collection
     */
    public function getStudents(): Collection
    {
        if (! $this->students instanceof Collection || $this->students->count() === 0)
        {
            $this->students = $this->getCourseClassPeople()->filter(function($entry) {
                return $entry->getRole() === 'Student';
            });
        }

        $iterator = $this->students->getIterator();
        $iterator->uasort(
            function ($a, $b) {
                return $a->getPerson()->getFullName() < $b->getPerson()->getFullName() ? -1 : 1 ;
            }
        );

        $this->students  = new ArrayCollection(iterator_to_array($iterator, false));


        return $this->students;
    }

    /**
     * __toArray
     * @param array $ignore
     * @return array
     */
    public function __toArray(array $ignore = []): array
    {
        return EntityHelper::__toArray(CourseClass::class, $this, $ignore);
    }
}