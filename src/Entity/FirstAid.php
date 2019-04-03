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
 * Class FirstAid
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FirstAidRepository")
 * @ORM\Table(name="FirstAid")
 * @ORM\HasLifecycleCallbacks()
 */
class FirstAid
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonFirstAidID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDPatient", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $patient;

    /**
     * @var CourseClass|null
     * @ORM\ManyToOne(targetEntity="CourseClass")
     * @ORM\JoinColumn(name="gibbonCourseClassID", referencedColumnName="gibbonCourseClassID")
     */
    private $courseClass;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDFirstAider", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $firstAider;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=false)
     */
    private $schoolYear;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="actionTaken")
     */
    private $actionTaken;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="followUp")
     */
    private $followUp;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="timeIn")
     */
    private $timeIn;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="timeOut", nullable=true)
     */
    private $timeOut;

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
     * @return FirstAid
     */
    public function setId(?int $id): FirstAid
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPatient(): ?Person
    {
        return $this->patient;
    }

    /**
     * @param Person|null $patient
     * @return FirstAid
     */
    public function setPatient(?Person $patient): FirstAid
    {
        $this->patient = $patient;
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
     * @return FirstAid
     */
    public function setCourseClass(?CourseClass $courseClass): FirstAid
    {
        $this->courseClass = $courseClass;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getFirstAider(): ?Person
    {
        return $this->firstAider;
    }

    /**
     * @param Person|null $firstAider
     * @return FirstAid
     */
    public function setFirstAider(?Person $firstAider): FirstAid
    {
        $this->firstAider = $firstAider;
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
     * @return FirstAid
     */
    public function setSchoolYear(?SchoolYear $schoolYear): FirstAid
    {
        $this->schoolYear = $schoolYear;
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
     * @return FirstAid
     */
    public function setDescription(?string $description): FirstAid
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionTaken(): ?string
    {
        return $this->actionTaken;
    }

    /**
     * @param string|null $actionTaken
     * @return FirstAid
     */
    public function setActionTaken(?string $actionTaken): FirstAid
    {
        $this->actionTaken = $actionTaken;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFollowUp(): ?string
    {
        return $this->followUp;
    }

    /**
     * @param string|null $followUp
     * @return FirstAid
     */
    public function setFollowUp(?string $followUp): FirstAid
    {
        $this->followUp = $followUp;
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
     * @return FirstAid
     */
    public function setDate(?\DateTime $date): FirstAid
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimeIn(): ?\DateTime
    {
        return $this->timeIn;
    }

    /**
     * @param \DateTime|null $timeIn
     * @return FirstAid
     */
    public function setTimeIn(?\DateTime $timeIn): FirstAid
    {
        $this->timeIn = $timeIn;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimeOut(): ?\DateTime
    {
        return $this->timeOut;
    }

    /**
     * @param \DateTime|null $timeOut
     * @return FirstAid
     */
    public function setTimeOut(?\DateTime $timeOut): FirstAid
    {
        $this->timeOut = $timeOut;
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
     * setTimestamp
     * @param \DateTime|null $timestamp
     * @return FirstAid
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestamp(?\DateTime $timestamp = null): FirstAid
    {
        $this->timestamp = $timestamp ?: new \DateTime('now');
        return $this;
    }
}