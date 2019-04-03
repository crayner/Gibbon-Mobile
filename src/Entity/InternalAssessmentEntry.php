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
 * Class InternalAssessmentEntry
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\InternalAssessmentEntryRepository")
 * @ORM\Table(name="InternalAssessmentEntry")
 */
class InternalAssessmentEntry
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonInternalAssessmentEntryID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var InternalAssessmentColumn|null
     * @ORM\ManyToOne(targetEntity="InternalAssessmentColumn")
     * @ORM\JoinColumn(name="gibbonInternalAssessmentColumnID", referencedColumnName="gibbonInternalAssessmentColumnID", nullable=false)
     */
    private $internalAssessmentColumn;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDStudent", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $student;

    /**
     * @var string|null
     * @ORM\Column(length=10, name="attainmentValue", nullable=true)
     */
    private $attainmentValue;

    /**
     * @var string|null
     * @ORM\Column(length=100, name="attainmentDescriptor", nullable=true)
     */
    private $attainmentDescriptor;

    /**
     * @var string|null
     * @ORM\Column(length=10, name="effortValue", nullable=true)
     */
    private $effortValue;

    /**
     * @var string|null
     * @ORM\Column(length=100, name="effortDescriptor", nullable=true)
     */
    private $effortDescriptor;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $response;

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
     * @return InternalAssessmentEntry
     */
    public function setId(?int $id): InternalAssessmentEntry
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return InternalAssessmentColumn|null
     */
    public function getInternalAssessmentColumn(): ?InternalAssessmentColumn
    {
        return $this->internalAssessmentColumn;
    }

    /**
     * @param InternalAssessmentColumn|null $internalAssessmentColumn
     * @return InternalAssessmentEntry
     */
    public function setInternalAssessmentColumn(?InternalAssessmentColumn $internalAssessmentColumn): InternalAssessmentEntry
    {
        $this->internalAssessmentColumn = $internalAssessmentColumn;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getStudent(): ?Person
    {
        return $this->student;
    }

    /**
     * @param Person|null $student
     * @return InternalAssessmentEntry
     */
    public function setStudent(?Person $student): InternalAssessmentEntry
    {
        $this->student = $student;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttainmentValue(): ?string
    {
        return $this->attainmentValue;
    }

    /**
     * @param string|null $attainmentValue
     * @return InternalAssessmentEntry
     */
    public function setAttainmentValue(?string $attainmentValue): InternalAssessmentEntry
    {
        $this->attainmentValue = $attainmentValue;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttainmentDescriptor(): ?string
    {
        return $this->attainmentDescriptor;
    }

    /**
     * @param string|null $attainmentDescriptor
     * @return InternalAssessmentEntry
     */
    public function setAttainmentDescriptor(?string $attainmentDescriptor): InternalAssessmentEntry
    {
        $this->attainmentDescriptor = $attainmentDescriptor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEffortValue(): ?string
    {
        return $this->effortValue;
    }

    /**
     * @param string|null $effortValue
     * @return InternalAssessmentEntry
     */
    public function setEffortValue(?string $effortValue): InternalAssessmentEntry
    {
        $this->effortValue = $effortValue;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEffortDescriptor(): ?string
    {
        return $this->effortDescriptor;
    }

    /**
     * @param string|null $effortDescriptor
     * @return InternalAssessmentEntry
     */
    public function setEffortDescriptor(?string $effortDescriptor): InternalAssessmentEntry
    {
        $this->effortDescriptor = $effortDescriptor;
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
     * @return InternalAssessmentEntry
     */
    public function setComment(?string $comment): InternalAssessmentEntry
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResponse(): ?string
    {
        return $this->response;
    }

    /**
     * @param string|null $response
     * @return InternalAssessmentEntry
     */
    public function setResponse(?string $response): InternalAssessmentEntry
    {
        $this->response = $response;
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
     * @return InternalAssessmentEntry
     */
    public function setLastEdit(?Person $lastEdit): InternalAssessmentEntry
    {
        $this->lastEdit = $lastEdit;
        return $this;
    }
}