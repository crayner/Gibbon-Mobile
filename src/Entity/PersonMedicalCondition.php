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
 * Class PersonMedicalCondition
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PersonMedicalConditionRepository")
 * @ORM\Table(name="PersonMedicalCondition", indexes={@ORM\Index(name="gibbonPersonMedicalID", columns={"gibbonPersonMedicalID"})})
 */
class PersonMedicalCondition
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonPersonMedicalConditionID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var PersonMedical|null
     * @ORM\ManyToOne(targetEntity="PersonMedical")
     * @ORM\JoinColumn(name="gibbonPersonMedicalID",referencedColumnName="gibbonPersonMedicalID", nullable=false)
     */
    private $personMedical;

    /**
     * @var string|null
     * @ORM\Column(length=100)
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PersonMedicalCondition
     */
    public function setId(?int $id): PersonMedicalCondition
    {
        $this->id = $id;
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
     * @return PersonMedicalCondition
     */
    public function setPersonMedical(?PersonMedical $personMedical): PersonMedicalCondition
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
     * @return PersonMedicalCondition
     */
    public function setName(?string $name): PersonMedicalCondition
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
     * @return PersonMedicalCondition
     */
    public function setAlertLevel(?AlertLevel $alertLevel): PersonMedicalCondition
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
     * @return PersonMedicalCondition
     */
    public function setTriggers(?string $triggers): PersonMedicalCondition
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
     * @return PersonMedicalCondition
     */
    public function setReaction(?string $reaction): PersonMedicalCondition
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
     * @return PersonMedicalCondition
     */
    public function setResponse(?string $response): PersonMedicalCondition
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
     * @return PersonMedicalCondition
     */
    public function setMedication(?string $medication): PersonMedicalCondition
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
     * @return PersonMedicalCondition
     */
    public function setLastEpisode(?\DateTime $lastEpisode): PersonMedicalCondition
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
     * @return PersonMedicalCondition
     */
    public function setLastEpisodeTreatment(?string $lastEpisodeTreatment): PersonMedicalCondition
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
     * @return PersonMedicalCondition
     */
    public function setComment(?string $comment): PersonMedicalCondition
    {
        $this->comment = $comment;
        return $this;
    }
}