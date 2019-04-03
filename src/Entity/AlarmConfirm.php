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
 * Class AlarmConfirm
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AlarmConfirmRepository")
 * @ORM\Table(name="AlarmConfirm", uniqueConstraints={@ORM\UniqueConstraint(name="gibbonAlarmID", columns={"gibbonAlarmID","gibbonPersonID"})})
 * @ORM\HasLifecycleCallbacks
 */
class AlarmConfirm
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonAlarmConfirmID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Alarm|null
     * @ORM\ManyToOne(targetEntity="Alarm")
     * @ORM\JoinColumn(name="gibbonAlarmID",referencedColumnName="gibbonAlarmID", nullable=false)
     */
    private $alarm;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var \DateTime
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
     * @return AlarmConfirm
     */
    public function setId(?int $id): AlarmConfirm
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Alarm|null
     */
    public function getAlarm(): ?Alarm
    {
        return $this->alarm;
    }

    /**
     * @param Alarm|null $alarm
     * @return AlarmConfirm
     */
    public function setAlarm(?Alarm $alarm): AlarmConfirm
    {
        $this->alarm = $alarm;
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
     * @return AlarmConfirm
     */
    public function setPerson(?Person $person): AlarmConfirm
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * setTimestamp
     * @param \DateTime|null $timestamp
     * @return AlarmConfirm
     * @throws \Exception
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setTimestamp(\DateTime $timestamp = null): AlarmConfirm
    {
        $this->timestamp = $timestamp ?: new \DateTime('now');
        return $this;
    }
}