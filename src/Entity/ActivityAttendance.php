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
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ActivityAttendance
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ActivityAttendanceRepository")
 * @ORM\Table(name="ActivityAttendance")
 * @ORM\HasLifecycleCallbacks
 */
class ActivityAttendance implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonActivityAttendanceID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ActivityAttendance
     */
    public function setId(?int $id): ActivityAttendance
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity")
     * @ORM\JoinColumn(name="gibbonActivityID",referencedColumnName="gibbonActivityID", nullable=false)
     */
    private $activity;

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return ActivityAttendance
     */
    public function setActivity(?Activity $activity): ActivityAttendance
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTaker",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personTaker;

    /**
     * @return Person|null
     */
    public function getPersonTaker(): ?Person
    {
        return $this->personTaker;
    }

    /**
     * @param Person|null $personTaker
     * @return ActivityAttendance
     */
    public function setPersonTaker(?Person $personTaker): ActivityAttendance
    {
        $this->personTaker = $personTaker;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $attendance;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @return string|null
     */
    public function getAttendance(): ?string
    {
        return $this->attendance;
    }

    /**
     * @param string|null $attendance
     * @return ActivityAttendance
     */
    public function setAttendance(?string $attendance): ActivityAttendance
    {
        $this->attendance = $attendance;
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
     * @return ActivityAttendance
     */
    public function setDate(?\DateTime $date): ActivityAttendance
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampTaken", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestampTaken;

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
     * @return ActivityAttendance
     * @throws \Exception
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setTimestampTaken(?\DateTime $timestampTaken = null): ActivityAttendance
    {
        $this->timestampTaken = $timestampTaken ?: new \DateTime('now');
        return $this;
    }
}