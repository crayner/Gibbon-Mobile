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
 * Class InternalAssessmentColumn
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\InternalAssessmentColumnRepository")
 * @ORM\Table(name="InternalAssessmentColumn")
 */
class InternalAssessmentColumn
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonInternalAssessmentColumnID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
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
     * @var integer|null
     * @ORM\Column(nullable=true, columnDefinition="INT(8) UNSIGNED ZEROFILL", options={"comment": "A value used to group multiple columns."}, name="groupingID", type="integer")
     */
    private $groupingID;

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
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $type;

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
     * @ORM\JoinColumn(name="gibbonScaleIDAttainment", referencedColumnName="gibbonScaleID", nullable=true)
     */
    private $scaleAttainment;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $effort = 'Y';

    /**
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleIDEffort", referencedColumnName="gibbonScaleID", nullable=true)
     */
    private $scaleEffort;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $comment = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="uploadedResponse", options={"default": "N"})
     */
    private $uploadedResponse = 'N';

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
     * @return InternalAssessmentColumn
     */
    public function setId(?int $id): InternalAssessmentColumn
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
     * @return InternalAssessmentColumn
     */
    public function setCourseClass(?CourseClass $courseClass): InternalAssessmentColumn
    {
        $this->courseClass = $courseClass;
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
     * @return InternalAssessmentColumn
     */
    public function setGroupingID(?int $groupingID): InternalAssessmentColumn
    {
        $this->groupingID = $groupingID;
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
     * @return InternalAssessmentColumn
     */
    public function setName(?string $name): InternalAssessmentColumn
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
     * @return InternalAssessmentColumn
     */
    public function setDescription(?string $description): InternalAssessmentColumn
    {
        $this->description = $description;
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
     * @return InternalAssessmentColumn
     */
    public function setType(?string $type): InternalAssessmentColumn
    {
        $this->type = $type;
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
     * @return InternalAssessmentColumn
     */
    public function setAttachment(?string $attachment): InternalAssessmentColumn
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
     * @return InternalAssessmentColumn
     */
    public function setAttainment(?string $attainment): InternalAssessmentColumn
    {
        $this->attainment = self::checkBoolean($attainment, 'Y');
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
     * @return InternalAssessmentColumn
     */
    public function setScaleAttainment(?Scale $scaleAttainment): InternalAssessmentColumn
    {
        $this->scaleAttainment = $scaleAttainment;
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
     * @return InternalAssessmentColumn
     */
    public function setEffort(?string $effort): InternalAssessmentColumn
    {
        $this->effort = self::checkBoolean($effort, 'Y');
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
     * @return InternalAssessmentColumn
     */
    public function setScaleEffort(?Scale $scaleEffort): InternalAssessmentColumn
    {
        $this->scaleEffort = $scaleEffort;
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
     * @return InternalAssessmentColumn
     */
    public function setComment(?string $comment): InternalAssessmentColumn
    {
        $this->comment = self::checkBoolean($comment, 'Y');
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
     * @return InternalAssessmentColumn
     */
    public function setUploadedResponse(?string $uploadedResponse): InternalAssessmentColumn
    {
        $this->uploadedResponse = self::checkBoolean($uploadedResponse, 'N');
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
     * @return InternalAssessmentColumn
     */
    public function setComplete(?string $complete): InternalAssessmentColumn
    {
        $this->complete = $complete;
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
     * @return InternalAssessmentColumn
     */
    public function setCompleteDate(?\DateTime $completeDate): InternalAssessmentColumn
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
     * @return InternalAssessmentColumn
     */
    public function setViewableStudents(?string $viewableStudents): InternalAssessmentColumn
    {
        $this->viewableStudents = $viewableStudents;
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
     * @return InternalAssessmentColumn
     */
    public function setViewableParents(?string $viewableParents): InternalAssessmentColumn
    {
        $this->viewableParents = $viewableParents;
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
     * @return InternalAssessmentColumn
     */
    public function setCreator(?Person $creator): InternalAssessmentColumn
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
     * @return InternalAssessmentColumn
     */
    public function setLastEdit(?Person $lastEdit): InternalAssessmentColumn
    {
        $this->lastEdit = $lastEdit;
        return $this;
    }
}