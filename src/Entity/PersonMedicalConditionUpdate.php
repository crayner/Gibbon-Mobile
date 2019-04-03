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
 * Class PersonMedicalConditionUpdate
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PersonMedicalConditionUpdateRepository")
 * @ORM\Table(name="PersonMedicalConditionUpdate")
 */
class PersonMedicalConditionUpdate
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonPersonMedicalConditionUpdateID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var PersonMedicalUpdate|null
     * @ORM\ManyToOne(targetEntity="PersonMedicalUpdate")
     * @ORM\JoinColumn(name="gibbonPersonMedicalUpdateID",referencedColumnName="gibbonPersonMedicalUpdateID")
     */
    private $personMedicalUpdate;

    /**
     * @var PersonMedicalCondition|null
     * @ORM\ManyToOne(targetEntity="PersonMedicalCondition")
     * @ORM\JoinColumn(name="gibbonPersonMedicalConditionID",referencedColumnName="gibbonPersonMedicalConditionID")
     */
    private $personMedicalCondition;

    /**
     * @var PersonMedical|null
     * @ORM\ManyToOne(targetEntity="PersonMedical")
     * @ORM\JoinColumn(name="gibbonPersonMedicalID",referencedColumnName="gibbonPersonMedicalID")
     */
    private $personMedical;

    /**
     * @var string|null
     * @ORM\Column(length=80)
     */
    private $name;

    /**
     * @var AlertLevel|null
     * @ORM\ManyToOne(targetEntity="AlertLevel")
     * @ORM\JoinColumn(name="gibbonAlertLevelID",referencedColumnName="gibbonAlertLevelID")
     */
    private $alertLevel;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $triggers;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $reaction;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $response;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $medication;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true, name="lastEpisode")
     */
    private $lastEpisode;

    /**
     * @var string|null
     * @ORM\Column(name="lastEpisodeTreatment")
     */
    private $lastEpisodeTreatment;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDUpdater", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personUpdater;

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
     * @return PersonMedicalConditionUpdate
     */
    public function setId(?int $id): PersonMedicalConditionUpdate
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return PersonMedicalUpdate|null
     */
    public function getPersonMedicalUpdate(): ?PersonMedicalUpdate
    {
        return $this->personMedicalUpdate;
    }

    /**
     * @param PersonMedicalUpdate|null $personMedicalUpdate
     * @return PersonMedicalConditionUpdate
     */
    public function setPersonMedicalUpdate(?PersonMedicalUpdate $personMedicalUpdate): PersonMedicalConditionUpdate
    {
        $this->personMedicalUpdate = $personMedicalUpdate;
        return $this;
    }

    /**
     * @return PersonMedicalCondition|null
     */
    public function getPersonMedicalCondition(): ?PersonMedicalCondition
    {
        return $this->personMedicalCondition;
    }

    /**
     * @param PersonMedicalCondition|null $personMedicalCondition
     * @return PersonMedicalConditionUpdate
     */
    public function setPersonMedicalCondition(?PersonMedicalCondition $personMedicalCondition): PersonMedicalConditionUpdate
    {
        $this->personMedicalCondition = $personMedicalCondition;
        return $this;
    }

    /**
     * @return PersonMedical|null
     */
    public function getPersonMedical(): ?PersonMedical
    {
        return $this->personMedical;
    }

    /**
     * @param PersonMedical|null $personMedical
     * @return PersonMedicalConditionUpdate
     */
    public function setPersonMedical(?PersonMedical $personMedical): PersonMedicalConditionUpdate
    {
        $this->personMedical = $personMedical;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return PersonMedicalConditionUpdate
     */
    public function setName(?string $name): PersonMedicalConditionUpdate
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return AlertLevel|null
     */
    public function getAlertLevel(): ?AlertLevel
    {
        return $this->alertLevel;
    }

    /**
     * @param AlertLevel|null $alertLevel
     * @return PersonMedicalConditionUpdate
     */
    public function setAlertLevel(?AlertLevel $alertLevel): PersonMedicalConditionUpdate
    {
        $this->alertLevel = $alertLevel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTriggers(): ?string
    {
        return $this->triggers;
    }

    /**
     * @param string|null $triggers
     * @return PersonMedicalConditionUpdate
     */
    public function setTriggers(?string $triggers): PersonMedicalConditionUpdate
    {
        $this->triggers = $triggers;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReaction(): ?string
    {
        return $this->reaction;
    }

    /**
     * @param string|null $reaction
     * @return PersonMedicalConditionUpdate
     */
    public function setReaction(?string $reaction): PersonMedicalConditionUpdate
    {
        $this->reaction = $reaction;
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
     * @return PersonMedicalConditionUpdate
     */
    public function setResponse(?string $response): PersonMedicalConditionUpdate
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMedication(): ?string
    {
        return $this->medication;
    }

    /**
     * @param string|null $medication
     * @return PersonMedicalConditionUpdate
     */
    public function setMedication(?string $medication): PersonMedicalConditionUpdate
    {
        $this->medication = $medication;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastEpisode(): ?\DateTime
    {
        return $this->lastEpisode;
    }

    /**
     * @param \DateTime|null $lastEpisode
     * @return PersonMedicalConditionUpdate
     */
    public function setLastEpisode(?\DateTime $lastEpisode): PersonMedicalConditionUpdate
    {
        $this->lastEpisode = $lastEpisode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastEpisodeTreatment(): ?string
    {
        return $this->lastEpisodeTreatment;
    }

    /**
     * @param string|null $lastEpisodeTreatment
     * @return PersonMedicalConditionUpdate
     */
    public function setLastEpisodeTreatment(?string $lastEpisodeTreatment): PersonMedicalConditionUpdate
    {
        $this->lastEpisodeTreatment = $lastEpisodeTreatment;
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
     * @return PersonMedicalConditionUpdate
     */
    public function setComment(?string $comment): PersonMedicalConditionUpdate
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonUpdater(): ?Person
    {
        return $this->personUpdater;
    }

    /**
     * @param Person|null $personUpdater
     * @return PersonMedicalConditionUpdate
     */
    public function setPersonUpdater(?Person $personUpdater): PersonMedicalConditionUpdate
    {
        $this->personUpdater = $personUpdater;
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
     * @return PersonMedicalConditionUpdate
     */
    public function setTimestamp(?\DateTime $timestamp): PersonMedicalConditionUpdate
    {
        $this->timestamp = $timestamp;
        return $this;
    }
}