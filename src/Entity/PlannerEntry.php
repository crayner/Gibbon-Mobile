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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class PlannerEntry
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PlannerEntryRepository")
 * @ORM\Table(name="PlannerEntry", indexes={@ORM\Index(name="gibbonCourseClassID", columns={"gibbonCourseClassID"})})
 */
class PlannerEntry implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonPlannerEntryID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var CourseClass|null
     * @ORM\ManyToOne(targetEntity="CourseClass")
     * @ORM\JoinColumn(name="gibbonCourseClassID", referencedColumnName="gibbonCourseClassID", nullable=false)
     */
    private $courseClass;

    /**
     * @var Unit|null
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumn(name="gibbonUnitID", referencedColumnName="gibbonUnitID", nullable=true)
     */
    private $unit;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time",name="timeStart", nullable=true)
     */
    private $timeStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time",name="timeEnd", nullable=true)
     */
    private $timeEnd;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $summary;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="teachersNotes")
     */
    private $teachersNotes;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $homework = 'N';

    /**
     * @var \DateTime|null
     * @ORM\Column(name="homeworkDueDateTime", type="datetime", nullable=true)
     */
    private $homeworkDueDateTime;

    /**
     * @var string|null
     * @ORM\Column(name="homeworkDetails", type="text")
     */
    private $homeworkDetails;

    /**
     * @var string|null
     * @ORM\Column(name="homeworkSubmission", length=1)
     */
    private $homeworkSubmission = '';

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true, name="homeworkSubmissionDateOpen")
     */
    private $homeworkSubmissionDateOpen;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="homeworkSubmissionDrafts", nullable=true)
     */
    private $homeworkSubmissionDrafts;

    /**
     * @var string|null
     * @ORM\Column(length=10, name="homeworkSubmissionType")
     */
    private $homeworkSubmissionType = '';

    /**
     * @var array
     */
    private static $homeworkSubmissionTypeList = ['', 'Link', 'File', 'Link/File'];

    /**
     * @var string|null
     * @ORM\Column(length=10, name="homeworkSubmissionRequired", options={"default": "Optional"}, nullable=true)
     */
    private $homeworkSubmissionRequired = 'Optional';

    /**
     * @var array
     */
    private static $homeworkSubmissionRequiredList = ['Optional', 'Compulsory'];

    /**
     * @var string|null
     * @ORM\Column(length=1, name="homeworkCrowdAssess")
     */
    private $homeworkCrowdAssess = '';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="homeworkCrowdAssessOtherTeachersRead")
     */
    private $homeworkCrowdAssessOtherTeachersRead = '';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="homeworkCrowdAssessOtherParentsRead")
     */
    private $homeworkCrowdAssessOtherParentsRead = '';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="homeworkCrowdAssessClassmatesParentsRead")
     */
    private $homeworkCrowdAssessClassmatesParentsRead = '';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="homeworkCrowdAssessSubmitterParentsRead")
     */
    private $homeworkCrowdAssessSubmitterParentsRead = '';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="homeworkCrowdAssessOtherStudentsRead")
     */
    private $homeworkCrowdAssessOtherStudentsRead = '';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="homeworkCrowdAssessClassmatesRead")
     */
    private $homeworkCrowdAssessClassmatesRead = '';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="viewableStudents", options={"default": "Y"})
     */
    private $viewableStudents = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="viewableParents", options={"default": "N"})
     */
    private $viewableParents = 'N';

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $creator;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDLastEdit", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $lastEdit;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Entity\PlannerEntryStudentHomework", mappedBy="plannerEntry")
     */
    private $studentHomeworkEntries;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Entity\PlannerEntryGuest", mappedBy="plannerEntry")
     */
    private $plannerEntryGuests;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PlannerEntry
     */
    public function setId(?int $id): PlannerEntry
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return CourseClass|null
     */
    public function getCourseClass(): ?CourseClass
    {
        return $this->courseClass;
    }

    /**
     * @param CourseClass|null $courseClass
     * @return PlannerEntry
     */
    public function setCourseClass(?CourseClass $courseClass): PlannerEntry
    {
        $this->courseClass = $courseClass;
        return $this;
    }

    /**
     * @return Unit|null
     */
    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    /**
     * @param Unit|null $unit
     * @return PlannerEntry
     */
    public function setUnit(?Unit $unit): PlannerEntry
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     * @return PlannerEntry
     */
    public function setDate(?\DateTime $date): PlannerEntry
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimeStart(): ?\DateTime
    {
        return $this->timeStart;
    }

    /**
     * @param \DateTime|null $timeStart
     * @return PlannerEntry
     */
    public function setTimeStart(?\DateTime $timeStart): PlannerEntry
    {
        $this->timeStart = $timeStart;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimeEnd(): ?\DateTime
    {
        return $this->timeEnd;
    }

    /**
     * @param \DateTime|null $timeEnd
     * @return PlannerEntry
     */
    public function setTimeEnd(?\DateTime $timeEnd): PlannerEntry
    {
        $this->timeEnd = $timeEnd;
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
     * @return PlannerEntry
     */
    public function setName(?string $name): PlannerEntry
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @param string|null $summary
     * @return PlannerEntry
     */
    public function setSummary(?string $summary): PlannerEntry
    {
        $this->summary = $summary;
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
     * @return PlannerEntry
     */
    public function setDescription(?string $description): PlannerEntry
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTeachersNotes(): ?string
    {
        return $this->teachersNotes;
    }

    /**
     * @param string|null $teachersNotes
     * @return PlannerEntry
     */
    public function setTeachersNotes(?string $teachersNotes): PlannerEntry
    {
        $this->teachersNotes = $teachersNotes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomework(): ?string
    {
        return $this->homework;
    }

    /**
     * @param string|null $homework
     * @return PlannerEntry
     */
    public function setHomework(?string $homework): PlannerEntry
    {
        $this->homework = self::checkBoolean($homework, 'N');
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getHomeworkDueDateTime(): ?\DateTime
    {
        return $this->homeworkDueDateTime;
    }

    /**
     * @param \DateTime|null $homeworkDueDateTime
     * @return PlannerEntry
     */
    public function setHomeworkDueDateTime(?\DateTime $homeworkDueDateTime): PlannerEntry
    {
        $this->homeworkDueDateTime = $homeworkDueDateTime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkDetails(): ?string
    {
        return $this->homeworkDetails;
    }

    /**
     * @param string|null $homeworkDetails
     * @return PlannerEntry
     */
    public function setHomeworkDetails(?string $homeworkDetails): PlannerEntry
    {
        $this->homeworkDetails = $homeworkDetails;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkSubmission(): ?string
    {
        return $this->homeworkSubmission;
    }

    /**
     * @param string|null $homeworkSubmission
     * @return PlannerEntry
     */
    public function setHomeworkSubmission(?string $homeworkSubmission): PlannerEntry
    {
        $this->homeworkSubmission = self::checkBoolean($homeworkSubmission, '');
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getHomeworkSubmissionDateOpen(): ?\DateTime
    {
        return $this->homeworkSubmissionDateOpen;
    }

    /**
     * @param \DateTime|null $homeworkSubmissionDateOpen
     * @return PlannerEntry
     */
    public function setHomeworkSubmissionDateOpen(?\DateTime $homeworkSubmissionDateOpen): PlannerEntry
    {
        $this->homeworkSubmissionDateOpen = $homeworkSubmissionDateOpen;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkSubmissionDrafts(): ?string
    {
        return $this->homeworkSubmissionDrafts;
    }

    /**
     * @param string|null $homeworkSubmissionDrafts
     * @return PlannerEntry
     */
    public function setHomeworkSubmissionDrafts(?string $homeworkSubmissionDrafts): PlannerEntry
    {
        $this->homeworkSubmissionDrafts = $homeworkSubmissionDrafts;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkSubmissionType(): ?string
    {
        return $this->homeworkSubmissionType;
    }

    /**
     * @param string|null $homeworkSubmissionType
     * @return PlannerEntry
     */
    public function setHomeworkSubmissionType(?string $homeworkSubmissionType): PlannerEntry
    {
        $this->homeworkSubmissionType = in_array($homeworkSubmissionType, self::getHomeworkSubmissionTypeList()) ? $homeworkSubmissionType : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkSubmissionRequired(): ?string
    {
        return $this->homeworkSubmissionRequired;
    }

    /**
     * @param string|null $homeworkSubmissionRequired
     * @return PlannerEntry
     */
    public function setHomeworkSubmissionRequired(?string $homeworkSubmissionRequired): PlannerEntry
    {
        $this->homeworkSubmissionRequired = in_array($homeworkSubmissionRequired, self::getHomeworkSubmissionRequiredList()) ? $homeworkSubmissionRequired : 'Optional';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkCrowdAssess(): ?string
    {
        return $this->homeworkCrowdAssess;
    }

    /**
     * @param string|null $homeworkCrowdAssess
     * @return PlannerEntry
     */
    public function setHomeworkCrowdAssess(?string $homeworkCrowdAssess): PlannerEntry
    {
        $this->homeworkCrowdAssess = self::checkBoolean($homeworkCrowdAssess, '');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkCrowdAssessOtherTeachersRead(): ?string
    {
        return $this->homeworkCrowdAssessOtherTeachersRead;
    }

    /**
     * @param string|null $homeworkCrowdAssessOtherTeachersRead
     * @return PlannerEntry
     */
    public function setHomeworkCrowdAssessOtherTeachersRead(?string $homeworkCrowdAssessOtherTeachersRead): PlannerEntry
    {
        $this->homeworkCrowdAssessOtherTeachersRead = self::checkBoolean($homeworkCrowdAssessOtherTeachersRead, '');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkCrowdAssessOtherParentsRead(): ?string
    {
        return $this->homeworkCrowdAssessOtherParentsRead;
    }

    /**
     * @param string|null $homeworkCrowdAssessOtherParentsRead
     * @return PlannerEntry
     */
    public function setHomeworkCrowdAssessOtherParentsRead(?string $homeworkCrowdAssessOtherParentsRead): PlannerEntry
    {
        $this->homeworkCrowdAssessOtherParentsRead = self::checkBoolean($homeworkCrowdAssessOtherParentsRead, '');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkCrowdAssessClassmatesParentsRead(): ?string
    {
        return $this->homeworkCrowdAssessClassmatesParentsRead;
    }

    /**
     * @param string|null $homeworkCrowdAssessClassmatesParentsRead
     * @return PlannerEntry
     */
    public function setHomeworkCrowdAssessClassmatesParentsRead(?string $homeworkCrowdAssessClassmatesParentsRead): PlannerEntry
    {
        $this->homeworkCrowdAssessClassmatesParentsRead = self::checkBoolean($homeworkCrowdAssessClassmatesParentsRead, '');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkCrowdAssessSubmitterParentsRead(): ?string
    {
        return $this->homeworkCrowdAssessSubmitterParentsRead;
    }

    /**
     * @param string|null $homeworkCrowdAssessSubmitterParentsRead
     * @return PlannerEntry
     */
    public function setHomeworkCrowdAssessSubmitterParentsRead(?string $homeworkCrowdAssessSubmitterParentsRead): PlannerEntry
    {
        $this->homeworkCrowdAssessSubmitterParentsRead = self::checkBoolean($homeworkCrowdAssessSubmitterParentsRead, '');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkCrowdAssessOtherStudentsRead(): ?string
    {
        return $this->homeworkCrowdAssessOtherStudentsRead;
    }

    /**
     * @param string|null $homeworkCrowdAssessOtherStudentsRead
     * @return PlannerEntry
     */
    public function setHomeworkCrowdAssessOtherStudentsRead(?string $homeworkCrowdAssessOtherStudentsRead): PlannerEntry
    {
        $this->homeworkCrowdAssessOtherStudentsRead = self::checkBoolean($homeworkCrowdAssessOtherStudentsRead, '');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeworkCrowdAssessClassmatesRead(): ?string
    {
        return $this->homeworkCrowdAssessClassmatesRead;
    }

    /**
     * @param string|null $homeworkCrowdAssessClassmatesRead
     * @return PlannerEntry
     */
    public function setHomeworkCrowdAssessClassmatesRead(?string $homeworkCrowdAssessClassmatesRead): PlannerEntry
    {
        $this->homeworkCrowdAssessClassmatesRead = self::checkBoolean($homeworkCrowdAssessClassmatesRead, '');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getViewableStudents(): ?string
    {
        return $this->viewableStudents;
    }

    /**
     * @param string|null $viewableStudents
     * @return PlannerEntry
     */
    public function setViewableStudents(?string $viewableStudents): PlannerEntry
    {
        $this->viewableStudents = self::checkBoolean($viewableStudents);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getViewableParents(): ?string
    {
        return $this->viewableParents;
    }

    /**
     * @param string|null $viewableParents
     * @return PlannerEntry
     */
    public function setViewableParents(?string $viewableParents): PlannerEntry
    {
        $this->viewableParents = self::checkBoolean($viewableParents, 'N');
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
     * @return PlannerEntry
     */
    public function setCreator(?Person $creator): PlannerEntry
    {
        $this->creator = $creator;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getLastEdit(): ?Person
    {
        return $this->lastEdit;
    }

    /**
     * @param Person|null $lastEdit
     * @return PlannerEntry
     */
    public function setLastEdit(?Person $lastEdit): PlannerEntry
    {
        $this->lastEdit = $lastEdit;
        return $this;
    }

    /**
     * @return array
     */
    public static function getHomeworkSubmissionTypeList(): array
    {
        return self::$homeworkSubmissionTypeList;
    }

    /**
     * @return array
     */
    public static function getHomeworkSubmissionRequiredList(): array
    {
        return self::$homeworkSubmissionRequiredList;
    }

    /**
     * getStudentHomeworkEntries
     * @return Collection|null
     */
    public function getStudentHomeworkEntries(): ?Collection
    {
        if (empty($this->studentHomeworkEntries))
            $this->studentHomeworkEntries = new ArrayCollection();

        if ($this->studentHomeworkEntries instanceof PersistentCollection)
            $this->studentHomeworkEntries->initialize();

        return $this->studentHomeworkEntries;
    }

    /**
     * @param Collection|null $studentHomeworkEntries
     * @return PlannerEntry
     */
    public function setStudentHomeworkEntries(?Collection $studentHomeworkEntries): PlannerEntry
    {
        $this->studentHomeworkEntries = $studentHomeworkEntries;
        return $this;
    }

    /**
     * getPlannerEntryGuests
     * @return Collection|null
     */
    public function getPlannerEntryGuests(): ?Collection
    {
        if (empty($this->plannerEntryGuests))
            $this->plannerEntryGuests = new ArrayCollection();

        if ($this->plannerEntryGuests instanceof PersistentCollection)
            $this->plannerEntryGuests->initialize();

        return $this->plannerEntryGuests;
    }

    /**
     * @param Collection|null $plannerEntryGuests
     * @return PlannerEntry
     */
    public function setPlannerEntryGuests(?Collection $plannerEntryGuests): PlannerEntry
    {
        $this->plannerEntryGuests = $plannerEntryGuests;
        return $this;
    }
}