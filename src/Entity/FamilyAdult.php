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

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class FamilyAdult
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FamilyAdultRepository")
 * @ORM\Table(name="FamilyAdult", indexes={@ORM\Index(name="gibbonFamilyID", columns={"gibbonFamilyID","contactPriority"}),@ORM\Index(name="gibbonPersonIndex", columns={"gibbonPersonID"})})
 */
class FamilyAdult
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonFamilyAdultID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Family|null
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="adults")
     * @ORM\JoinColumn(name="gibbonFamilyID", referencedColumnName="gibbonFamilyID", nullable=false)
     */
    private $family;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="childDataAccess")
     */
    private $childDataAccess;

    /**
     * @var string|null
     * @ORM\Column(type="smallint", name="contactPriority", options={"default": 1}, columnDefinition="INT(2)")
     */
    private $contactPriority;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="contactCall")
     */
    private $contactCall;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="contactSMS")
     */
    private $contactSMS;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="contactEmail")
     */
    private $contactEmail;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="contactMail")
     */
    private $contactMail;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FamilyAdult
     */
    public function setId(?int $id): FamilyAdult
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Family|null
     */
    public function getFamily(): ?Family
    {
        return $this->family;
    }

    /**
     * @param Family|null $family
     * @return FamilyAdult
     */
    public function setFamily(?Family $family): FamilyAdult
    {
        $this->family = $family;
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
     * @return FamilyAdult
     */
    public function setPerson(?Person $person): FamilyAdult
    {
        $this->person = $person;
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
     * @return FamilyAdult
     */
    public function setComment(?string $comment): FamilyAdult
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChildDataAccess(): ?string
    {
        return $this->childDataAccess;
    }

    /**
     * @param string|null $childDataAccess
     * @return FamilyAdult
     */
    public function setChildDataAccess(?string $childDataAccess): FamilyAdult
    {
        $this->childDataAccess = $childDataAccess;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactPriority(): ?string
    {
        return $this->contactPriority;
    }

    /**
     * @param string|null $contactPriority
     * @return FamilyAdult
     */
    public function setContactPriority(?string $contactPriority): FamilyAdult
    {
        $this->contactPriority = $contactPriority;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactCall(): ?string
    {
        return $this->contactCall;
    }

    /**
     * @param string|null $contactCall
     * @return FamilyAdult
     */
    public function setContactCall(?string $contactCall): FamilyAdult
    {
        $this->contactCall = $contactCall;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactSMS(): ?string
    {
        return $this->contactSMS;
    }

    /**
     * @param string|null $contactSMS
     * @return FamilyAdult
     */
    public function setContactSMS(?string $contactSMS): FamilyAdult
    {
        $this->contactSMS = $contactSMS;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    /**
     * @param string|null $contactEmail
     * @return FamilyAdult
     */
    public function setContactEmail(?string $contactEmail): FamilyAdult
    {
        $this->contactEmail = $contactEmail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactMail(): ?string
    {
        return $this->contactMail;
    }

    /**
     * @param string|null $contactMail
     * @return FamilyAdult
     */
    public function setContactMail(?string $contactMail): FamilyAdult
    {
        $this->contactMail = $contactMail;
        return $this;
    }
}