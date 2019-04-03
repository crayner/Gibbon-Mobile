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
 * Class Staff
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StaffRepository")
 * @ORM\Table(name="Staff", uniqueConstraints={@ORM\UniqueConstraint(name="gibbonPersonID", columns={"gibbonPersonID"}), @ORM\UniqueConstraint(name="initials", columns={"initials"})})
 */
class Staff implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonStaffID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\OneToOne(targetEntity="Person", inversedBy="staff")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(length=4, nullable=true)
     */
    private $initials;

    /**
     * @var string|null
     * @ORM\Column(length=100, name="jobTitle")
     */
    private $jobTitle;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="smartWorkflowHelp", options={"default": "Y"})
     */
    private $smartWorkflowHelp = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="firstAidQualified")
     */
    private $firstAidQualified;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="firstAidExpiry", nullable=true)
     */
    private $firstAidExpiry;

    /**
     * @var string|null
     * @ORM\Column(length=80, name="countryOfOrigin")
     */
    private $countryOfOrigin;

    /**
     * @var string|null
     * @ORM\Column(name="qualifications")
     */
    private $qualifications;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $biography;

    /**
     * @var string|null
     * @ORM\Column(length=100, name="biographicalGrouping", options={"comment": "Used for group staff when creating a staff directory."})
     */
    private $biographicalGrouping;

    /**
     * @var integer|null
     * @ORM\Column(name="biographicalGroupingPriority", type="smallint", columnDefinition="INT(3)")
     */
    private $biographicalGroupingPriority;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Staff
     */
    public function setId(?int $id): Staff
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
     * setPerson
     * @param Person|null $person
     * @param bool $add
     * @return Staff
     */
    public function setPerson(?Person $person, bool $add = true): Staff
    {
        if ($person instanceof Person)
            $person->setStaff($this, false);
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Staff
     */
    public function setType(?string $type): Staff
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInitials(): ?string
    {
        return $this->initials;
    }

    /**
     * @param string|null $initials
     * @return Staff
     */
    public function setInitials(?string $initials): Staff
    {
        $this->initials = $initials;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    /**
     * @param string|null $jobTitle
     * @return Staff
     */
    public function setJobTitle(?string $jobTitle): Staff
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSmartWorkflowHelp(): ?string
    {
        return $this->smartWorkflowHelp;
    }

    /**
     * @param string|null $smartWorkflowHelp
     * @return Staff
     */
    public function setSmartWorkflowHelp(?string $smartWorkflowHelp): Staff
    {
        $this->smartWorkflowHelp = self::checkBoolean($smartWorkflowHelp);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstAidQualified(): ?string
    {
        return $this->firstAidQualified;
    }

    /**
     * @param string|null $firstAidQualified
     * @return Staff
     */
    public function setFirstAidQualified(?string $firstAidQualified): Staff
    {
        $this->firstAidQualified = self::checkBoolean($firstAidQualified, 'N');
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getFirstAidExpiry(): ?\DateTime
    {
        return $this->firstAidExpiry;
    }

    /**
     * @param \DateTime|null $firstAidExpiry
     * @return Staff
     */
    public function setFirstAidExpiry(?\DateTime $firstAidExpiry): Staff
    {
        $this->firstAidExpiry = $firstAidExpiry;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryOfOrigin(): ?string
    {
        return $this->countryOfOrigin;
    }

    /**
     * @param string|null $countryOfOrigin
     * @return Staff
     */
    public function setCountryOfOrigin(?string $countryOfOrigin): Staff
    {
        $this->countryOfOrigin = $countryOfOrigin;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQualifications(): ?string
    {
        return $this->qualifications;
    }

    /**
     * @param string|null $qualifications
     * @return Staff
     */
    public function setQualifications(?string $qualifications): Staff
    {
        $this->qualifications = $qualifications;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }

    /**
     * @param string|null $biography
     * @return Staff
     */
    public function setBiography(?string $biography): Staff
    {
        $this->biography = $biography;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBiographicalGrouping(): ?string
    {
        return $this->biographicalGrouping;
    }

    /**
     * @param string|null $biographicalGrouping
     * @return Staff
     */
    public function setBiographicalGrouping(?string $biographicalGrouping): Staff
    {
        $this->biographicalGrouping = $biographicalGrouping;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getBiographicalGroupingPriority(): ?int
    {
        return $this->biographicalGroupingPriority;
    }

    /**
     * @param int|null $biographicalGroupingPriority
     * @return Staff
     */
    public function setBiographicalGroupingPriority(?int $biographicalGroupingPriority): Staff
    {
        $this->biographicalGroupingPriority = $biographicalGroupingPriority;
        return $this;
    }
}