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
 * Class MarkbookColumn
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MarkbookColumnRepository")
 * @ORM\Table(name="MarkbookColumn", indexes={@ORM\Index(name="gibbonCourseClassID", columns={"gibbonCourseClassID"}), @ORM\Index(name="completeDate", columns={"completeDate"}), @ORM\Index(name="complete", columns={"complete"})})
 */
class MarkbookColumn
{
    use BooleanList;
    
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonMarkbookColumnID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
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
     * @var Hook|null
     * @ORM\ManyToOne(targetEntity="Hook")
     * @ORM\JoinColumn(name="gibbonHookID", referencedColumnName="gibbonHookID")
     */
    private $hook;

    /**
     * @var Unit|null
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumn(name="gibbonUnitID", referencedColumnName="gibbonUnitID")
     */
    private $unit;

    /**
     * @var PlannerEntry|null
     * @ORM\ManyToOne(targetEntity="PlannerEntry")
     * @ORM\JoinColumn(name="gibbonPlannerEntryID", referencedColumnName="gibbonPlannerEntryID")
     */
    private $plannerEntry;

    /**
     * @var SchoolYearTerm|null
     * @ORM\ManyToOne(targetEntity="SchoolYearTerm")
     * @ORM\JoinColumn(name="gibbonSchoolYearTermID", referencedColumnName="gibbonSchoolYearTermID")
     */
    private $schoolYearTerm;

    /**
     * @var integer|null
     * @ORM\Column(nullable=true, type="integer", columnDefinition="INT(8) UNSIGNED ZEROFILL", options={"comment": "A value used to group multiple markbook columns."}, name="groupingID")
     */
    private $groupingID;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var int
     * @ORM\Column(type="smallint",columnDefinition="INT(3) UNSIGNED",name="sequenceNumber", options={"default": "0"})
     */
    private $sequenceNumber;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $attachment;
    
    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $attainment = 'Y';

    /**
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleIDAttainment", referencedColumnName="gibbonScaleID")
     */
    private $scaleAttainment;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=5, scale=2, name="attainmentWeighting", nullable=true)
     */
    private $attainmentWeighting;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="attainmentRaw", options={"default": "N"})
     */
    private $attainmentRaw = 'N';

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=8, scale=2, name="attainmentRawMax", nullable=true)
     */
    private $attainmentRawMax;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $effort = 'Y';

    /**
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleIDEffort", referencedColumnName="gibbonScaleID")
     */
    private $scaleEffort;

    /**
     * @var Rubric|null
     * @ORM\ManyToOne(targetEntity="Rubric")
     * @ORM\JoinColumn(name="gibbonRubricIDAttainment", referencedColumnName="gibbonRubricID")
     */
    private $rubricAttainment;

    /**
     * @var Rubric|null
     * @ORM\ManyToOne(targetEntity="Rubric")
     * @ORM\JoinColumn(name="gibbonRubricIDEffort", referencedColumnName="gibbonRubricID")
     */
    private $rubricEffort;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $comment = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="uploadedResponse", options={"default": "Y"})
     */
    private $uploadedResponse = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $complete = 'N';

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="completeDate", nullable=true)
     */
    private $completeDate;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="viewableStudents")
     */
    private $viewableStudents = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="viewableParents")
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return MarkbookColumn
     */
    public function setId(?int $id): MarkbookColumn
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
     * @return MarkbookColumn
     */
    public function setCourseClass(?CourseClass $courseClass): MarkbookColumn
    {
        $this->courseClass = $courseClass;
        return $this;
    }

    /**
     * @return Hook|null
     */
    public function getHook(): ?Hook
    {
        return $this->hook;
    }

    /**
     * @param Hook|null $hook
     * @return MarkbookColumn
     */
    public function setHook(?Hook $hook): MarkbookColumn
    {
        $this->hook = $hook;
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
     * @return MarkbookColumn
     */
    public function setUnit(?Unit $unit): MarkbookColumn
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @return PlannerEntry|null
     */
    public function getPlannerEntry(): ?PlannerEntry
    {
        return $this->plannerEntry;
    }

    /**
     * @param PlannerEntry|null $plannerEntry
     * @return MarkbookColumn
     */
    public function setPlannerEntry(?PlannerEntry $plannerEntry): MarkbookColumn
    {
        $this->plannerEntry = $plannerEntry;
        return $this;
    }

    /**
     * @return SchoolYearTerm|null
     */
    public function getSchoolYearTerm(): ?SchoolYearTerm
    {
        return $this->schoolYearTerm;
    }

    /**
     * @param SchoolYearTerm|null $schoolYearTerm
     * @return MarkbookColumn
     */
    public function setSchoolYearTerm(?SchoolYearTerm $schoolYearTerm): MarkbookColumn
    {
        $this->schoolYearTerm = $schoolYearTerm;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGroupingID(): ?int
    {
        return $this->groupingID;
    }

    /**
     * @param int|null $groupingID
     * @return MarkbookColumn
     */
    public function setGroupingID(?int $groupingID): MarkbookColumn
    {
        $this->groupingID = $groupingID;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return MarkbookColumn
     */
    public function setType(?string $type): MarkbookColumn
    {
        $this->type = $type;
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
     * @return MarkbookColumn
     */
    public function setName(?string $name): MarkbookColumn
    {
        $this->name = $name;
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
     * @return MarkbookColumn
     */
    public function setDescription(?string $description): MarkbookColumn
    {
        $this->description = $description;
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
     * @return MarkbookColumn
     */
    public function setDate(?\DateTime $date): MarkbookColumn
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getSequenceNumber(): int
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int $sequenceNumber
     * @return MarkbookColumn
     */
    public function setSequenceNumber(int $sequenceNumber): MarkbookColumn
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    /**
     * @param string|null $attachment
     * @return MarkbookColumn
     */
    public function setAttachment(?string $attachment): MarkbookColumn
    {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttainment(): ?string
    {
        return $this->attainment;
    }

    /**
     * @param string|null $attainment
     * @return MarkbookColumn
     */
    public function setAttainment(?string $attainment): MarkbookColumn
    {
        $this->attainment = self::checkBoolean($attainment);
        return $this;
    }

    /**
     * @return Scale|null
     */
    public function getScaleAttainment(): ?Scale
    {
        return $this->scaleAttainment;
    }

    /**
     * @param Scale|null $scaleAttainment
     * @return MarkbookColumn
     */
    public function setScaleAttainment(?Scale $scaleAttainment): MarkbookColumn
    {
        $this->scaleAttainment = $scaleAttainment;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAttainmentWeighting(): ?float
    {
        return $this->attainmentWeighting;
    }

    /**
     * @param float|null $attainmentWeighting
     * @return MarkbookColumn
     */
    public function setAttainmentWeighting(?float $attainmentWeighting): MarkbookColumn
    {
        $this->attainmentWeighting = $attainmentWeighting;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttainmentRaw(): ?string
    {
        return $this->attainmentRaw;
    }

    /**
     * @param string|null $attainmentRaw
     * @return MarkbookColumn
     */
    public function setAttainmentRaw(?string $attainmentRaw): MarkbookColumn
    {
        $this->attainmentRaw = self::checkBoolean($attainmentRaw, 'N');
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAttainmentRawMax(): ?float
    {
        return $this->attainmentRawMax;
    }

    /**
     * @param float|null $attainmentRawMax
     * @return MarkbookColumn
     */
    public function setAttainmentRawMax(?float $attainmentRawMax): MarkbookColumn
    {
        $this->attainmentRawMax = $attainmentRawMax;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEffort(): ?string
    {
        return $this->effort;
    }

    /**
     * @param string|null $effort
     * @return MarkbookColumn
     */
    public function setEffort(?string $effort): MarkbookColumn
    {
        $this->effort = self::checkBoolean($effort);
        return $this;
    }

    /**
     * @return Scale|null
     */
    public function getScaleEffort(): ?Scale
    {
        return $this->scaleEffort;
    }

    /**
     * @param Scale|null $scaleEffort
     * @return MarkbookColumn
     */
    public function setScaleEffort(?Scale $scaleEffort): MarkbookColumn
    {
        $this->scaleEffort = $scaleEffort;
        return $this;
    }

    /**
     * @return Rubric|null
     */
    public function getRubricAttainment(): ?Rubric
    {
        return $this->rubricAttainment;
    }

    /**
     * @param Rubric|null $rubricAttainment
     * @return MarkbookColumn
     */
    public function setRubricAttainment(?Rubric $rubricAttainment): MarkbookColumn
    {
        $this->rubricAttainment = $rubricAttainment;
        return $this;
    }

    /**
     * @return Rubric|null
     */
    public function getRubricEffort(): ?Rubric
    {
        return $this->rubricEffort;
    }

    /**
     * @param Rubric|null $rubricEffort
     * @return MarkbookColumn
     */
    public function setRubricEffort(?Rubric $rubricEffort): MarkbookColumn
    {
        $this->rubricEffort = $rubricEffort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return MarkbookColumn
     */
    public function setComment(?string $comment): MarkbookColumn
    {
        $this->comment = self::checkBoolean($comment);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUploadedResponse(): ?string
    {
        return $this->uploadedResponse;
    }

    /**
     * @param string|null $uploadedResponse
     * @return MarkbookColumn
     */
    public function setUploadedResponse(?string $uploadedResponse): MarkbookColumn
    {
        $this->uploadedResponse = self::checkBoolean($uploadedResponse);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComplete(): ?string
    {
        return $this->complete;
    }

    /**
     * @param string|null $complete
     * @return MarkbookColumn
     */
    public function setComplete(?string $complete): MarkbookColumn
    {
        $this->complete = self::checkBoolean($complete, 'N');
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCompleteDate(): ?\DateTime
    {
        return $this->completeDate;
    }

    /**
     * @param \DateTime|null $completeDate
     * @return MarkbookColumn
     */
    public function setCompleteDate(?\DateTime $completeDate): MarkbookColumn
    {
        $this->completeDate = $completeDate;
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
     * @return MarkbookColumn
     */
    public function setViewableStudents(?string $viewableStudents): MarkbookColumn
    {
        $this->viewableStudents = self::checkBoolean($viewableStudents, 'N');
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
     * @return MarkbookColumn
     */
    public function setViewableParents(?string $viewableParents): MarkbookColumn
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
     * @return MarkbookColumn
     */
    public function setCreator(?Person $creator): MarkbookColumn
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
     * @return MarkbookColumn
     */
    public function setLastEdit(?Person $lastEdit): MarkbookColumn
    {
        $this->lastEdit = $lastEdit;
        return $this;
    }
}