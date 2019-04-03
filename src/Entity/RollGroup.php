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
 * Class RollGroup
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RollGroupRepository")
 * @ORM\Table(name="RollGroup")
 */
class RollGroup implements EntityInterface
{
    use BooleanList;
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="smallint", name="gibbonRollGroupID", columnDefinition="INT(5) UNSIGNED ZEROFILL")
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
     * @var string|null
     * @ORM\Column(length=10)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=5, name="nameShort")
     */
    private $nameShort;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTutor",referencedColumnName="gibbonPersonID")
     */
    private $tutor;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTutor2",referencedColumnName="gibbonPersonID")
     */
    private $tutor2;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTutor3",referencedColumnName="gibbonPersonID")
     */
    private $tutor3;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDEA",referencedColumnName="gibbonPersonID")
     */
    private $assistant;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDEA2",referencedColumnName="gibbonPersonID")
     */
    private $assistant2;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDEA3",referencedColumnName="gibbonPersonID")
     */
    private $assistant3;

    /**
     * @var Space|null
     * @ORM\ManyToOne(targetEntity="Space")
     * @ORM\JoinColumn(name="gibbonSpaceID", referencedColumnName="gibbonSpaceID", nullable=true)
     */
    private $space;

    /**
     * @var RollGroup|null
     * @ORM\ManyToOne(targetEntity="RollGroup")
     * @ORM\JoinColumn(name="gibbonRollGroupIDNext", referencedColumnName="gibbonRollGroupID", nullable=true)
     */
    private $nextRollGroup;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $attendance = 'Y';

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $website;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Entity\StudentEnrolment", mappedBy="rollGroup")
     */
    private $studentEnrolments;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return RollGroup
     */
    public function setId(?int $id): RollGroup
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
     * @return RollGroup
     */
    public function setSchoolYear(?SchoolYear $schoolYear): RollGroup
    {
        $this->schoolYear = $schoolYear;
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
     * @return RollGroup
     */
    public function setName(?string $name): RollGroup
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
     * @return RollGroup
     */
    public function setNameShort(?string $nameShort): RollGroup
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getTutor(): ?Person
    {
        return $this->tutor;
    }

    /**
     * @param Person|null $tutor
     * @return RollGroup
     */
    public function setTutor(?Person $tutor): RollGroup
    {
        $this->tutor = $tutor;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getTutor2(): ?Person
    {
        return $this->tutor2;
    }

    /**
     * @param Person|null $tutor2
     * @return RollGroup
     */
    public function setTutor2(?Person $tutor2): RollGroup
    {
        $this->tutor2 = $tutor2;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getTutor3(): ?Person
    {
        return $this->tutor3;
    }

    /**
     * @param Person|null $tutor3
     * @return RollGroup
     */
    public function setTutor3(?Person $tutor3): RollGroup
    {
        $this->tutor3 = $tutor3;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getAssistant(): ?Person
    {
        return $this->assistant;
    }

    /**
     * @param Person|null $assistant
     * @return RollGroup
     */
    public function setAssistant(?Person $assistant): RollGroup
    {
        $this->assistant = $assistant;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getAssistant2(): ?Person
    {
        return $this->assistant2;
    }

    /**
     * @param Person|null $assistant2
     * @return RollGroup
     */
    public function setAssistant2(?Person $assistant2): RollGroup
    {
        $this->assistant2 = $assistant2;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getAssistant3(): ?Person
    {
        return $this->assistant3;
    }

    /**
     * @param Person|null $assistant3
     * @return RollGroup
     */
    public function setAssistant3(?Person $assistant3): RollGroup
    {
        $this->assistant3 = $assistant3;
        return $this;
    }

    /**
     * @return Space|null
     */
    public function getSpace(): ?Space
    {
        return $this->space;
    }

    /**
     * @param Space|null $space
     * @return RollGroup
     */
    public function setSpace(?Space $space): RollGroup
    {
        $this->space = $space;
        return $this;
    }

    /**
     * @return RollGroup|null
     */
    public function getNextRollGroup(): ?RollGroup
    {
        return $this->nextRollGroup;
    }

    /**
     * @param RollGroup|null $nextRollGroup
     * @return RollGroup
     */
    public function setNextRollGroup(?RollGroup $nextRollGroup): RollGroup
    {
        $this->nextRollGroup = $nextRollGroup;
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
     * @return RollGroup
     */
    public function setAttendance(?string $attendance): RollGroup
    {
        $this->attendance = self::checkBoolean($attendance);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string|null $website
     * @return RollGroup
     */
    public function setWebsite(?string $website): RollGroup
    {
        $this->website = $website;
        return $this;
    }

    /**
     * getStudentEnrolments
     * @return Collection
     */
    public function getStudentEnrolments(): Collection
    {
        if (empty($this->studentEnrolments))
            $this->studentEnrolments = new ArrayCollection();

        if ($this->studentEnrolments instanceof PersistentCollection)
            $this->studentEnrolments->initialize();

        return $this->studentEnrolments;
    }

    /**
     * @param Collection|null $studentEnrolments
     * @return RollGroup
     */
    public function setStudentEnrolments(?Collection $studentEnrolments): RollGroup
    {
        $this->studentEnrolments = $studentEnrolments;
        return $this;
    }

    /**
     * __toArray
     * @param array $ignore
     * @return array
     */
    public function __toArray(array $ignore = []): array
    {
        return EntityHelper::__toArray(RollGroup::class, $this, $ignore);
    }
}