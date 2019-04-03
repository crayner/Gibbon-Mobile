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
use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DaysOfWeek
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\DaysOfWeekRepository")
 * @ORM\Table(name="DaysOfWeek", uniqueConstraints={@ORM\UniqueConstraint(name="name",columns={"name", "nameShort"}),@ORM\UniqueConstraint(name="nameShort",columns={"nameShort"}), @ORM\UniqueConstraint(name="sequenceNumber",columns={"sequenceNumber"}) })
 */
class DaysOfWeek implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonDaysOfWeekID", columnDefinition="INT(2) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(length=10)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(length=4, name="nameShort")
     */
    private $nameShort;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="sequenceNumber", columnDefinition="INT(2)")
     */
    private $sequenceNumber;

    /**
     * @var string
     * @ORM\Column(length=1, name="schoolDay", options={"default": "Y"})
     */
    private $schoolDay = 'Y';

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="schoolOpen", nullable=true)
     */
    private $schoolOpen;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="schoolStart", nullable=true)
     */
    private $schoolStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="schoolEnd", nullable=true)
     */
    private $schoolEnd;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="schoolClose", nullable=true)
     */
    private $schoolClose;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return DaysOfWeek
     */
    public function setId(?int $id): DaysOfWeek
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DaysOfWeek
     */
    public function setName(string $name): DaysOfWeek
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameShort(): string
    {
        return $this->nameShort;
    }

    /**
     * @param string $nameShort
     * @return DaysOfWeek
     */
    public function setNameShort(string $nameShort): DaysOfWeek
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int|null $sequenceNumber
     * @return DaysOfWeek
     */
    public function setSequenceNumber(?int $sequenceNumber): DaysOfWeek
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    public function isSchoolDay(): bool
    {
        return $this->isTrueOrFalse($this->getSchoolDay());
    }
    /**
     * @return string
     */
    public function getSchoolDay(): string
    {
        return $this->schoolDay = self::checkBoolean($this->schoolDay, 'Y');
    }

    /**
     * @param string $schoolDay
     * @return DaysOfWeek
     */
    public function setSchoolDay(string $schoolDay): DaysOfWeek
    {
        $this->schoolDay = self::checkBoolean($schoolDay, 'Y');
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getSchoolOpen(): ?\DateTime
    {
        return $this->schoolOpen;
    }

    /**
     * @param \DateTime|null $schoolOpen
     * @return DaysOfWeek
     */
    public function setSchoolOpen(?\DateTime $schoolOpen): DaysOfWeek
    {
        $this->schoolOpen = $schoolOpen;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getSchoolStart(): ?\DateTime
    {
        return $this->schoolStart;
    }

    /**
     * @param \DateTime|null $schoolStart
     * @return DaysOfWeek
     */
    public function setSchoolStart(?\DateTime $schoolStart): DaysOfWeek
    {
        $this->schoolStart = $schoolStart;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getSchoolEnd(): ?\DateTime
    {
        return $this->schoolEnd;
    }

    /**
     * @param \DateTime|null $schoolEnd
     * @return DaysOfWeek
     */
    public function setSchoolEnd(?\DateTime $schoolEnd): DaysOfWeek
    {
        $this->schoolEnd = $schoolEnd;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getSchoolClose(): ?\DateTime
    {
        return $this->schoolClose;
    }

    /**
     * @param \DateTime|null $schoolClose
     * @return DaysOfWeek
     */
    public function setSchoolClose(?\DateTime $schoolClose): DaysOfWeek
    {
        $this->schoolClose = $schoolClose;
        return $this;
    }
}