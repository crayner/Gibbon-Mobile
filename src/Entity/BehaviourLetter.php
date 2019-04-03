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
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class BehaviourLetter
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\BehaviourLetterRepository")
 * @ORM\Table(name="BehaviourLetter")
 * @ORM\HasLifecycleCallbacks
 */
class BehaviourLetter
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonBehaviourLetterID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
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
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(name="letterLevel", length=1)
     */
    private $letterLevel;

    /**
     * @var array
     */
    private static $letterLevelList = ['1','2','3'];

    /**
     * @var string|null
     * @ORM\Column(length=7)
     */
    private $status;

    /**
     * @var array
     */
    private static $statusList = ['Warning', 'Issued'];

    /**
     * @var integer|null
     * @ORM\Column(type="smallint",columnDefinition="INT(3)", name="recordCountAtCreation")
     */
    private $recordCountAtCreation;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="recipientList")
     */
    private $recipientList;

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
     * @return BehaviourLetter
     */
    public function setId(?int $id): BehaviourLetter
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
     * @return BehaviourLetter
     */
    public function setSchoolYear(?SchoolYear $schoolYear): BehaviourLetter
    {
        $this->schoolYear = $schoolYear;
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
     * @return BehaviourLetter
     */
    public function setPerson(?Person $person): BehaviourLetter
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLetterLevel(): ?string
    {
        return $this->letterLevel;
    }

    /**
     * @param string|null $letterLevel
     * @return BehaviourLetter
     */
    public function setLetterLevel(?string $letterLevel): BehaviourLetter
    {
        $this->letterLevel = $letterLevel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return BehaviourLetter
     */
    public function setStatus(?string $status): BehaviourLetter
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRecordCountAtCreation(): ?int
    {
        return $this->recordCountAtCreation;
    }

    /**
     * @param int|null $recordCountAtCreation
     * @return BehaviourLetter
     */
    public function setRecordCountAtCreation(?int $recordCountAtCreation): BehaviourLetter
    {
        $this->recordCountAtCreation = $recordCountAtCreation;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     * @return BehaviourLetter
     */
    public function setBody(?string $body): BehaviourLetter
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecipientList(): ?string
    {
        return $this->recipientList;
    }

    /**
     * @param string|null $recipientList
     * @return BehaviourLetter
     */
    public function setRecipientList(?string $recipientList): BehaviourLetter
    {
        $this->recipientList = $recipientList;
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
     * @return BehaviourLetter
     * @ORM\PrePersist()
     */
    public function setTimestamp(?\DateTime $timestamp = null): BehaviourLetter
    {
        $this->timestamp = $timestamp ?: new DateTime('now');
        return $this;
    }

    /**
     * @return array
     */
    public static function getLetterLevelList(): array
    {
        return self::$letterLevelList;
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }
}