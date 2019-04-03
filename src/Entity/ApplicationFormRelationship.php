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
 * Class ApplicationFormRelationship
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationFormRelationshipRepository")
 * @ORM\Table(name="ApplicationFormRelationship")
 */
class ApplicationFormRelationship
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonApplicationFormRelationshipID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var ApplicationForm|null
     * @ORM\ManyToOne(targetEntity="ApplicationForm")
     * @ORM\JoinColumn(name="gibbonApplicationFormID", referencedColumnName="gibbonApplicationFormID", nullable=false)
     */
    private $applicationForm;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $relationship;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ApplicationFormRelationship
     */
    public function setId(?int $id): ApplicationFormRelationship
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ApplicationForm|null
     */
    public function getApplicationForm(): ?ApplicationForm
    {
        return $this->applicationForm;
    }

    /**
     * @param ApplicationForm|null $applicationForm
     * @return ApplicationFormRelationship
     */
    public function setApplicationForm(?ApplicationForm $applicationForm): ApplicationFormRelationship
    {
        $this->applicationForm = $applicationForm;
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
     * @return ApplicationFormRelationship
     */
    public function setPerson(?Person $person): ApplicationFormRelationship
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    /**
     * @param string|null $relationship
     * @return ApplicationFormRelationship
     */
    public function setRelationship(?string $relationship): ApplicationFormRelationship
    {
        $this->relationship = $relationship;
        return $this;
    }
}