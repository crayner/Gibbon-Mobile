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
 * Class Behaviour
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\BehaviourRepository")
 * @ORM\Table(name="Behaviour", indexes={@ORM\Index(name="gibbonPersonID",columns={"gibbonPersonID"})})
 * @ORM\HasLifecycleCallbacks
 */
class Behaviour
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonBehaviourID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
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
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=8)
     */
    private $type;

    /**
     * @var array
     */
    private $typeList = ['Positive', 'Negative'];

    /**
     * @var string|null
     * @ORM\Column(length=100, nullable=true)
     */
    private $descriptor;

    /**
     * @var string|null
     * @ORM\Column(length=100, nullable=true)
     */
    private $level;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $followup;

    /**
     * @var PlannerEntry|null
     * @ORM\ManyToOne(targetEntity="PlannerEntry")
     * @ORM\JoinColumn(name="gibbonPlannerEntryID", referencedColumnName="gibbonPlannerEntryID")
     */
    private $plannerEntry;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personCreator;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestamp;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Behaviour
     */
    public function setId(?int $id): Behaviour
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
     * @return Behaviour
     */
    public function setSchoolYear(?SchoolYear $schoolYear): Behaviour
    {
        $this->schoolYear = $schoolYear;
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
     * @return Behaviour
     */
    public function setDate(?\DateTime $date): Behaviour
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * @param Person|null $person
     * @return Behaviour
     */
    public function setPerson(?Person $person): Behaviour
    {
        $this->person = $person;
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
     * @return Behaviour
     */
    public function setType(?string $type): Behaviour
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function getTypeList(): array
    {
        return $this->typeList;
    }

    /**
     * @param array $typeList
     * @return Behaviour
     */
    public function setTypeList(array $typeList): Behaviour
    {
        $this->typeList = $typeList;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescriptor(): ?string
    {
        return $this->descriptor;
    }

    /**
     * @param string|null $descriptor
     * @return Behaviour
     */
    public function setDescriptor(?string $descriptor): Behaviour
    {
        $this->descriptor = $descriptor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLevel(): ?string
    {
        return $this->level;
    }

    /**
     * @param string|null $level
     * @return Behaviour
     */
    public function setLevel(?string $level): Behaviour
    {
        $this->level = $level;
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
     * @return Behaviour
     */
    public function setComment(?string $comment): Behaviour
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFollowup(): ?string
    {
        return $this->followup;
    }

    /**
     * @param string|null $followup
     * @return Behaviour
     */
    public function setFollowup(?string $followup): Behaviour
    {
        $this->followup = $followup;
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
     * @return Behaviour
     */
    public function setPlannerEntry(?PlannerEntry $plannerEntry): Behaviour
    {
        $this->plannerEntry = $plannerEntry;
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
     * @return Behaviour
     */
    public function setPersonCreator(?Person $personCreator): Behaviour
    {
        $this->personCreator = $personCreator;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime|null $timestamp
     * @return Behaviour
     */
    public function setTimestamp(?\DateTime $timestamp): Behaviour
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * updateTimestamp
     * @return Behaviour
     * @throws \Exception
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTimestamp(): Behaviour
    {
        return $this->setTimestamp(new \DateTime('now'));
    }
}