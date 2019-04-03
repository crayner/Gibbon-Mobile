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
 * Class StaffContract
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StaffContractRepository")
 * @ORM\Table(name="StaffContract")
 * @ORM\HasLifecycleCallbacks()
 */
class StaffContract
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonStaffContractID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Staff|null
     * @ORM\ManyToOne(targetEntity="Staff")
     * @ORM\JoinColumn(name="gibbonStaffID", referencedColumnName="gibbonStaffID", nullable=false)
     */
    private $staff;

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(length=8)
     */
    private $status = '';

    /**
     * @var array
     */
    private static $statusList = ['', 'Pending', 'Active', 'Expired'];

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="dateStart")
     */
    private $dateStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="dateEnd", nullable=true)
     */
    private $dateEnd;

    /**
     * @var string|null
     * @ORM\Column(name="salaryScale", nullable=true)
     */
    private $salaryScale;

    /**
     * @var float|null
     * @ORM\Column(name="salaryAmount", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $salaryAmount;

    /**
     * @var string|null
     * @ORM\Column(name="salaryPeriod", nullable=true)
     */
    private $salaryPeriod = '';

    /**
     * @var array 
     */
    private static $periodList = ['', 'Week', 'Month', 'Year', 'Contract'];

    /**
     * @var string|null
     * @ORM\Column(name="responsibility", nullable=true)
     */
    private $responsibility;

    /**
     * @var float|null
     * @ORM\Column(name="responsibilityAmount", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $responsibilityAmount;

    /**
     * @var string|null
     * @ORM\Column(name="responsibilityPeriod", nullable=true)
     */
    private $responsibilityPeriod = '';

    /**
     * @var float|null
     * @ORM\Column(name="housingAmount", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $housingAmount;

    /**
     * @var string|null
     * @ORM\Column(name="housingPeriod", nullable=true)
     */
    private $housingPeriod = '';

    /**
     * @var float|null
     * @ORM\Column(name="travelAmount", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $travelAmount;

    /**
     * @var string|null
     * @ORM\Column(name="travelPeriod", nullable=true)
     */
    private $travelPeriod = '';

    /**
     * @var float|null
     * @ORM\Column(name="retirementAmount", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $retirementAmount;

    /**
     * @var string|null
     * @ORM\Column(name="retirementPeriod", nullable=true)
     */
    private $retirementPeriod = '';

    /**
     * @var float|null
     * @ORM\Column(name="bonusAmount", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $bonusAmount;

    /**
     * @var string|null
     * @ORM\Column(name="bonusPeriod", nullable=true)
     */
    private $bonusPeriod = '';

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $education;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $notes;

    /**
     * @var string|null
     * @ORM\Column(name="contractUpload", nullable=true)
     */
    private $contractUpload;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personCreator;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampCreator", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestampCreator;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return StaffContract
     */
    public function setId(?int $id): StaffContract
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Staff|null
     */
    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    /**
     * @param Staff|null $staff
     * @return StaffContract
     */
    public function setStaff(?Staff $staff): StaffContract
    {
        $this->staff = $staff;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return StaffContract
     */
    public function setTitle(?string $title): StaffContract
    {
        $this->title = $title;
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
     * @return StaffContract
     */
    public function setStatus(?string $status): StaffContract
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime|null $dateStart
     * @return StaffContract
     */
    public function setDateStart(?\DateTime $dateStart): StaffContract
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime|null $dateEnd
     * @return StaffContract
     */
    public function setDateEnd(?\DateTime $dateEnd): StaffContract
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalaryScale(): ?string
    {
        return $this->salaryScale;
    }

    /**
     * @param string|null $salaryScale
     * @return StaffContract
     */
    public function setSalaryScale(?string $salaryScale): StaffContract
    {
        $this->salaryScale = $salaryScale;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getSalaryAmount(): ?float
    {
        return $this->salaryAmount;
    }

    /**
     * @param float|null $salaryAmount
     * @return StaffContract
     */
    public function setSalaryAmount(?float $salaryAmount): StaffContract
    {
        $this->salaryAmount = $salaryAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalaryPeriod(): ?string
    {
        return $this->salaryPeriod;
    }

    /**
     * @param string|null $salaryPeriod
     * @return StaffContract
     */
    public function setSalaryPeriod(?string $salaryPeriod): StaffContract
    {
        $this->salaryPeriod = in_array($salaryPeriod, self::getPeriodList()) ? $salaryPeriod : null;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResponsibility(): ?string
    {
        return $this->responsibility;
    }

    /**
     * @param string|null $responsibility
     * @return StaffContract
     */
    public function setResponsibility(?string $responsibility): StaffContract
    {
        $this->responsibility = $responsibility;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getResponsibilityAmount(): ?float
    {
        return $this->responsibilityAmount;
    }

    /**
     * @param float|null $responsibilityAmount
     * @return StaffContract
     */
    public function setResponsibilityAmount(?float $responsibilityAmount): StaffContract
    {
        $this->responsibilityAmount = $responsibilityAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResponsibilityPeriod(): ?string
    {
        return $this->responsibilityPeriod;
    }

    /**
     * @param string|null $responsibilityPeriod
     * @return StaffContract
     */
    public function setResponsibilityPeriod(?string $responsibilityPeriod): StaffContract
    {
        $this->responsibilityPeriod = in_array($responsibilityPeriod, self::getPeriodList()) ? $responsibilityPeriod : null;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getHousingAmount(): ?float
    {
        return $this->housingAmount;
    }

    /**
     * @param float|null $housingAmount
     * @return StaffContract
     */
    public function setHousingAmount(?float $housingAmount): StaffContract
    {
        $this->housingAmount = $housingAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHousingPeriod(): ?string
    {
        return $this->housingPeriod;
    }

    /**
     * @param string|null $housingPeriod
     * @return StaffContract
     */
    public function setHousingPeriod(?string $housingPeriod): StaffContract
    {
        $this->housingPeriod = in_array($housingPeriod, self::getPeriodList()) ? $housingPeriod : null;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getTravelAmount(): ?float
    {
        return $this->travelAmount;
    }

    /**
     * @param float|null $travelAmount
     * @return StaffContract
     */
    public function setTravelAmount(?float $travelAmount): StaffContract
    {
        $this->travelAmount = $travelAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTravelPeriod(): ?string
    {
        return $this->travelPeriod;
    }

    /**
     * @param string|null $travelPeriod
     * @return StaffContract
     */
    public function setTravelPeriod(?string $travelPeriod): StaffContract
    {
        $this->travelPeriod = in_array($travelPeriod, self::getPeriodList()) ? $travelPeriod : null;;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getRetirementAmount(): ?float
    {
        return $this->retirementAmount;
    }

    /**
     * @param float|null $retirementAmount
     * @return StaffContract
     */
    public function setRetirementAmount(?float $retirementAmount): StaffContract
    {
        $this->retirementAmount = $retirementAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRetirementPeriod(): ?string
    {
        return $this->retirementPeriod;
    }

    /**
     * @param string|null $retirementPeriod
     * @return StaffContract
     */
    public function setRetirementPeriod(?string $retirementPeriod): StaffContract
    {
        $this->retirementPeriod = in_array($retirementPeriod, self::getPeriodList()) ? $retirementPeriod : null;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getBonusAmount(): ?float
    {
        return $this->bonusAmount;
    }

    /**
     * @param float|null $bonusAmount
     * @return StaffContract
     */
    public function setBonusAmount(?float $bonusAmount): StaffContract
    {
        $this->bonusAmount = $bonusAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBonusPeriod(): ?string
    {
        return $this->bonusPeriod;
    }

    /**
     * @param string|null $bonusPeriod
     * @return StaffContract
     */
    public function setBonusPeriod(?string $bonusPeriod): StaffContract
    {
        $this->bonusPeriod = in_array($bonusPeriod, self::getPeriodList()) ? $bonusPeriod : null;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEducation(): ?string
    {
        return $this->education;
    }

    /**
     * @param string|null $education
     * @return StaffContract
     */
    public function setEducation(?string $education): StaffContract
    {
        $this->education = $education;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     * @return StaffContract
     */
    public function setNotes(?string $notes): StaffContract
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContractUpload(): ?string
    {
        return $this->contractUpload;
    }

    /**
     * @param string|null $contractUpload
     * @return StaffContract
     */
    public function setContractUpload(?string $contractUpload): StaffContract
    {
        $this->contractUpload = $contractUpload;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonCreator(): ?Person
    {
        return $this->personCreator;
    }

    /**
     * @param Person|null $personCreator
     * @return StaffContract
     */
    public function setPersonCreator(?Person $personCreator): StaffContract
    {
        $this->personCreator = $personCreator;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampCreator(): ?\DateTime
    {
        return $this->timestampCreator;
    }

    /**
     * setTimestampCreator
     * @param \DateTime|null $timestampCreator
     * @return StaffContract
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestampCreator(?\DateTime $timestampCreator = null): StaffContract
    {
        $this->timestampCreator = $timestampCreator ?: new \DateTime('now');
        return $this;
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }

    /**
     * @return array
     */
    public static function getPeriodList(): array
    {
        return self::$periodList;
    }
}