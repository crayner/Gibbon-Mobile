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

use App\Util\UserHelper;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AttendanceLogCourseClass
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AttendanceLogCourseClassRepository")
 * @ORM\Table(name="AttendanceLogCourseClass")
 * @ORM\HasLifecycleCallbacks()
 */
class AttendanceLogCourseClass
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonAttendanceLogCourseClassID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
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
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTaker", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampTaken", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestampTaken;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return AttendanceLogCourseClass
     */
    public function setId(?int $id): AttendanceLogCourseClass
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
     * @return AttendanceLogCourseClass
     */
    public function setCourseClass(?CourseClass $courseClass): AttendanceLogCourseClass
    {
        $this->courseClass = $courseClass;
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
     * @return AttendanceLogCourseClass
     */
    public function setPerson(?Person $person): AttendanceLogCourseClass
    {
        $this->person = $person;
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
     * @return AttendanceLogCourseClass
     */
    public function setDate(?\DateTime $date): AttendanceLogCourseClass
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampTaken(): ?\DateTime
    {
        return $this->timestampTaken;
    }

    /**
     * setTimestampTaken
     * @param \DateTime|null $timestampTaken
     * @return AttendanceLogCourseClass
     * @throws \Exception
     */
    public function setTimestampTaken(?\DateTime $timestampTaken = null): AttendanceLogCourseClass
    {
        $this->timestampTaken = $timestampTaken ?: new \DateTime('now');
        return $this;
    }

    /**
     * updateTimestamp
     * @return AttendanceLogCourseClass
     * @throws \Exception
     */
    public function updateTimestamp(): AttendanceLogCourseClass
    {
        return $this->setTimestampTaken(new \DateTime('now'));
    }

    /**
     * setTakerTime
     * @return AttendanceLogCourseClass
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTakerTime(): AttendanceLogCourseClass
    {
        return $this->setTimestampTaken(new \DateTime('now'))->setPerson(UserHelper::getCurrentUser());
    }
}