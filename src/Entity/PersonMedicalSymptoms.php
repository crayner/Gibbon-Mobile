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
 * Class PersonMedicalSymptoms
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PersonMedicalSymptomsRepository")
 * @ORM\Table(name="PersonMedicalSymptoms")
 * @ORM\HasLifecycleCallbacks()
 */
class PersonMedicalSymptoms
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonPersonMedicalSymptomsID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $symptoms;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampTaken", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestampTaken;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDTaker",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personTaker;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PersonMedicalSymptoms
     */
    public function setId(?int $id): PersonMedicalSymptoms
    {
        $this->id = $id;
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
     * @return PersonMedicalSymptoms
     */
    public function setPerson(?Person $person): PersonMedicalSymptoms
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSymptoms(): ?string
    {
        return $this->symptoms;
    }

    /**
     * @param string|null $symptoms
     * @return PersonMedicalSymptoms
     */
    public function setSymptoms(?string $symptoms): PersonMedicalSymptoms
    {
        $this->symptoms = $symptoms;
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
     * @return PersonMedicalSymptoms
     */
    public function setDate(?\DateTime $date): PersonMedicalSymptoms
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
     * @return PersonMedicalSymptoms
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestampTaken(?\DateTime $timestampTaken = null): PersonMedicalSymptoms
    {
        $this->timestampTaken = $timestampTaken ?: new \DateTime('now');
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
     * @return PersonMedicalSymptoms
     */
    public function setPersonTaker(?Person $personTaker): PersonMedicalSymptoms
    {
        $this->personTaker = $personTaker;
        return $this;
    }
}