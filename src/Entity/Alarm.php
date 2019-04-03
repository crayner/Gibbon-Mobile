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
 * Class Alarm
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AlarmRepository")
 * @ORM\Table(name="Alarm")
 */
class Alarm
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonAlarmID", columnDefinition="INT(5) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=8, nullable=true)
     */
    private $type;

    /**
     * @var array
     */
    private static $typeList = ['General', 'Lockdown', 'Custom'];

    /**
     * @var string
     * @ORM\Column(length=7, options={"default": "Past"})
     */
    private $status = 'Past';

    /**
     * @var array
     */
    private static $statusList = ['Current', 'Past'];

    /**
     * @var integer|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true, name="timestampStart")
     */
    private $timestampStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true, name="timestampEnd")
     */
    private $timestampEnd;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Alarm
     */
    public function setId(?int $id): Alarm
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Alarm
     */
    public function setType(?string $type): Alarm
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : null ;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Alarm
     */
    public function setStatus(string $status): Alarm
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Past';
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPerson(): ?int
    {
        return $this->person;
    }

    /**
     * @param int|null $person
     * @return Alarm
     */
    public function setPerson(?int $person): Alarm
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampStart(): ?\DateTime
    {
        return $this->timestampStart;
    }

    /**
     * @param \DateTime|null $timestampStart
     * @return Alarm
     */
    public function setTimestampStart(?\DateTime $timestampStart): Alarm
    {
        $this->timestampStart = $timestampStart;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampEnd(): ?\DateTime
    {
        return $this->timestampEnd;
    }

    /**
     * @param \DateTime|null $timestampEnd
     * @return Alarm
     */
    public function setTimestampEnd(?\DateTime $timestampEnd): Alarm
    {
        $this->timestampEnd = $timestampEnd;
        return $this;
    }

    /**
     * @return array
     */
    public static function getTypeList(): array
    {
        return self::$typeList;
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }
}