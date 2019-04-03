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
 * Class MarkbookEntry
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MarkbookEntryRepository")
 * @ORM\Table(name="MarkbookEntry", indexes={@ORM\Index(name="gibbonPersonIDStudent", columns={"gibbonPersonIDStudent"}), @ORM\Index(name="gibbonMarkbookColumnID", columns={"gibbonMarkbookColumnID"})})
 */
class MarkbookEntry
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonMarkbookEntryID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var MarkbookColumn|null
     * @ORM\ManyToOne(targetEntity="MarkbookColumn")
     * @ORM\JoinColumn(name="gibbonMarkbookColumnID", referencedColumnName="gibbonMarkbookColumnID", nullable=false)
     */
    private $markbookColumn;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDStudent", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $student;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="modifiedAssessment", nullable=true)
     */
    private $modifiedAssessment = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=10, name="attainmentValue", nullable=true)
     */
    private $attainmentValue;

    /**
     * @var string|null
     * @ORM\Column(length=10, name="attainmentValueRaw", nullable=true)
     */
    private $attainmentValueRaw;

    /**
     * @var string|null
     * @ORM\Column(length=100, name="attainmentDescriptor", nullable=true)
     */
    private $attainmentDescriptor;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="attainmentConcern", options={"comment": "'P' denotes that student has exceed their personal target"}, nullable=true)
     */
    private $attainmentConcern;

    /**
     * @var array 
     */
    private static $attainmentConcernList = ['N', 'Y', 'P'];

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
     * @ORM\Column(length=1, name="effortConcern", nullable=true)
     */
    private $effortConcern = 'N';

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
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
     * @return MarkbookEntry
     */
    public function setId(?int $id): MarkbookEntry
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return MarkbookColumn|null
     */
    public function getMarkbookColumn(): ?MarkbookColumn
    {
        return $this->markbookColumn;
    }

    /**
     * @param MarkbookColumn|null $markbookColumn
     * @return MarkbookEntry
     */
    public function setMarkbookColumn(?MarkbookColumn $markbookColumn): MarkbookEntry
    {
        $this->markbookColumn = $markbookColumn;
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
     * @return MarkbookEntry
     */
    public function setStudent(?Person $student): MarkbookEntry
    {
        $this->student = $student;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getModifiedAssessment(): ?string
    {
        return $this->modifiedAssessment;
    }

    /**
     * @param string|null $modifiedAssessment
     * @return MarkbookEntry
     */
    public function setModifiedAssessment(?string $modifiedAssessment): MarkbookEntry
    {
        $this->modifiedAssessment = self::checkBoolean($modifiedAssessment, 'N');
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
     * @return MarkbookEntry
     */
    public function setAttainmentValue(?string $attainmentValue): MarkbookEntry
    {
        $this->attainmentValue = $attainmentValue;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttainmentValueRaw(): ?string
    {
        return $this->attainmentValueRaw;
    }

    /**
     * @param string|null $attainmentValueRaw
     * @return MarkbookEntry
     */
    public function setAttainmentValueRaw(?string $attainmentValueRaw): MarkbookEntry
    {
        $this->attainmentValueRaw = $attainmentValueRaw;
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
     * @return MarkbookEntry
     */
    public function setAttainmentDescriptor(?string $attainmentDescriptor): MarkbookEntry
    {
        $this->attainmentDescriptor = $attainmentDescriptor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttainmentConcern(): ?string
    {
        return $this->attainmentConcern;
    }

    /**
     * @param string|null $attainmentConcern
     * @return MarkbookEntry
     */
    public function setAttainmentConcern(?string $attainmentConcern): MarkbookEntry
    {
        $this->attainmentConcern = in_array($attainmentConcern, self::getAttainmentConcernList()) ? $attainmentConcern : 'N' ;
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
     * @return MarkbookEntry
     */
    public function setEffortValue(?string $effortValue): MarkbookEntry
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
     * @return MarkbookEntry
     */
    public function setEffortDescriptor(?string $effortDescriptor): MarkbookEntry
    {
        $this->effortDescriptor = $effortDescriptor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEffortConcern(): ?string
    {
        return $this->effortConcern;
    }

    /**
     * @param string|null $effortConcern
     * @return MarkbookEntry
     */
    public function setEffortConcern(?string $effortConcern): MarkbookEntry
    {
        $this->effortConcern = self::checkBoolean($effortConcern, 'N');
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
     * @return MarkbookEntry
     */
    public function setComment(?string $comment): MarkbookEntry
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
     * @return MarkbookEntry
     */
    public function setResponse(?string $response): MarkbookEntry
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
     * @return MarkbookEntry
     */
    public function setLastEdit(?Person $lastEdit): MarkbookEntry
    {
        $this->lastEdit = $lastEdit;
        return $this;
    }

    /**
     * @return array
     */
    public static function getAttainmentConcernList(): array
    {
        return self::$attainmentConcernList;
    }
}