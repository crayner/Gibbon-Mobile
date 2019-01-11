<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon, Flexible & Open School System
 * Copyright (C) 2010, Ross Parker
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the LICENCE file.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * Gibbon-Mobile
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
 * Class AttendanceLogPerson
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AttendanceLogPersonRepository")
 * @ORM\Table(name="AttendanceLogPerson", indexes={@ORM\Index(name="date", columns={"date"}),@ORM\Index(name="dateAndPerson", columns={"date","gibbonPersonID"}),@ORM\Index(name="gibbonPersonID", columns={"gibbonPersonID"})})
 * @ORM\HasLifecycleCallbacks()
 */
class AttendanceLogPerson
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonAttendanceLogPersonID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="AttendanceCode")
     * @ORM\JoinColumn(name="gibbonAttendanceCodeID", referencedColumnName="gibbonAttendanceCodeID")
     */
    private $attendanceCode;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=3)
     */
    private $direction;

    /**
     * @var array
     */
    private static $directionList = ['In','Out'];

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $reason;

    /**
     * @var string|null
     * @ORM\Column(length=20, nullable=true)
     */
    private $context;

    /**
     * @var array
     */
    private static $contentList = ['Roll Group','Class','Person','Future','Self Registration'];

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $comment;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTaker", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personTaker;

    /**
     * @var CourseClass|null
     * @ORM\ManyToOne(targetEntity="CourseClass")
     * @ORM\JoinColumn(name="gibbonCourseClassID", referencedColumnName="gibbonCourseClassID")
     */
    private $courseClass;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampTaken", nullable=true)
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
     * @return AttendanceLogPerson
     */
    public function setId(?int $id): AttendanceLogPerson
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getAttendanceCode(): ?AttendanceCode
    {
        return $this->attendanceCode;
    }

    /**
     * setAttendanceCode
     * @param AttendanceCode|null $attendanceCode
     * @return AttendanceLogPerson
     */
    public function setAttendanceCode(?AttendanceCode $attendanceCode): AttendanceLogPerson
    {
        $this->attendanceCode = $attendanceCode;
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
     * @return AttendanceLogPerson
     */
    public function setPerson(?Person $person): AttendanceLogPerson
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDirection(): ?string
    {
        return $this->direction ?: ($this->getAttendanceCode() ? $this->getAttendanceCode()->getDirection() : null);
    }

    /**
     * @param string|null $direction
     * @return AttendanceLogPerson
     */
    public function setDirection(?string $direction): AttendanceLogPerson
    {
        $this->direction = $direction ?: ($this->getAttendanceCode() ? $this->getAttendanceCode()->getDirection() : null);;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type ?: ($this->getAttendanceCode() ? $this->getAttendanceCode()->getName() : null);
    }

    /**
     * @param string|null $type
     * @return AttendanceLogPerson
     */
    public function setType(?string $type): AttendanceLogPerson
    {
        $this->type = $type ?: ($this->getAttendanceCode() ? $this->getAttendanceCode()->getName() : null);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string|null $reason
     * @return AttendanceLogPerson
     */
    public function setReason(?string $reason): AttendanceLogPerson
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContext(): ?string
    {
        return $this->context;
    }

    /**
     * @param string|null $context
     * @return AttendanceLogPerson
     */
    public function setContext(?string $context): AttendanceLogPerson
    {
        $this->context = $context;
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
     * @return AttendanceLogPerson
     */
    public function setComment(?string $comment): AttendanceLogPerson
    {
        $this->comment = $comment;
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
     * @return AttendanceLogPerson
     */
    public function setDate(?\DateTime $date): AttendanceLogPerson
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonTaker(): ?Person
    {
        return $this->personTaker;
    }

    /**
     * @param Person|null $personTaker
     * @return AttendanceLogPerson
     */
    public function setPersonTaker(?Person $personTaker): AttendanceLogPerson
    {
        $this->personTaker = $personTaker;
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
     * @return AttendanceLogPerson
     */
    public function setCourseClass(?CourseClass $courseClass): AttendanceLogPerson
    {
        $this->courseClass = $courseClass;
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
     * @param \DateTime|null $timestampTaken
     * @return AttendanceLogPerson
     */
    public function setTimestampTaken(?\DateTime $timestampTaken): AttendanceLogPerson
    {
        $this->timestampTaken = $timestampTaken;
        return $this;
    }

    /**
     * @return array
     */
    public static function getDirectionList(): array
    {
        return self::$directionList;
    }

    /**
     * @return array
     */
    public static function getContentList(): array
    {
        return self::$contentList;
    }

    /**
     * updateTakenTime
     * @return AttendanceLogPerson
     * @throws \Exception
     * @ORM\PreUpdate()
     */
    public function updateTakenTime()
    {
        return $this->setTimestampTaken(new \DateTime('now'));
    }

    /**
     * setTakerTime
     * @return AttendanceLogPerson
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTakerTime(): AttendanceLogPerson
    {
        return $this->setTimestampTaken(new \DateTime('now'))->setPersonTaker(UserHelper::getCurrentUser())->setDirection(null)->setType(null);
    }
}