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
 * Class FinanceFee
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceFeeRepository")
 * @ORM\Table(name="FinanceFee")
 * @ORM\HasLifecycleCallbacks
 */
class FinanceFee
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonFinanceFeeID", columnDefinition="INT(6) UNSIGNED ZEROFILL")
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
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $active = 'Y';

    /**
     * @var FinanceFeeCategory|null
     * @ORM\ManyToOne(targetEntity="FinanceFeeCategory")
     * @ORM\JoinColumn(name="gibbonFinanceFeeCategoryID", referencedColumnName="gibbonFinanceFeeCategoryID", nullable=false)
     */
    private $financeFeeCategory;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $fee;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personCreator;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampCreator", nullable=true)
     */
    private $timestampCreator;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDUpdate", referencedColumnName="gibbonPersonID")
     */
    private $personUpdate;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampUpdate", nullable=true)
     */
    private $timestampUpdate;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FinanceFee
     */
    public function setId(?int $id): FinanceFee
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
     * @return FinanceFee
     */
    public function setSchoolYear(?SchoolYear $schoolYear): FinanceFee
    {
        $this->schoolYear = $schoolYear;
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
     * @return FinanceFee
     */
    public function setName(?string $name): FinanceFee
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameShort(): ?string
    {
        return $this->nameShort;
    }

    /**
     * @param string|null $nameShort
     * @return FinanceFee
     */
    public function setNameShort(?string $nameShort): FinanceFee
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return FinanceFee
     */
    public function setDescription(?string $description): FinanceFee
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * @param string|null $active
     * @return FinanceFee
     */
    public function setActive(?string $active): FinanceFee
    {
        $this->active = self::checkBoolean($active);
        return $this;
    }

    /**
     * @return FinanceFeeCategory|null
     */
    public function getFinanceFeeCategory(): ?FinanceFeeCategory
    {
        return $this->financeFeeCategory;
    }

    /**
     * @param FinanceFeeCategory|null $financeFeeCategory
     * @return FinanceFee
     */
    public function setFinanceFeeCategory(?FinanceFeeCategory $financeFeeCategory): FinanceFee
    {
        $this->financeFeeCategory = $financeFeeCategory;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getFee(): ?float
    {
        return $this->fee;
    }

    /**
     * @param float|null $fee
     * @return FinanceFee
     */
    public function setFee(?float $fee): FinanceFee
    {
        $this->fee = number_format($fee, 2);
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
     * @return FinanceFee
     */
    public function setPersonCreator(?Person $personCreator): FinanceFee
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
     * @param \DateTime|null $timestampCreator
     * @return FinanceFee
     */
    public function setTimestampCreator(?\DateTime $timestampCreator = null): FinanceFee
    {
        $this->timestampCreator = $timestampCreator ?: new \DateTime('now') ;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonUpdate(): ?Person
    {
        return $this->personUpdate;
    }

    /**
     * @param Person|null $personUpdate
     * @return FinanceFee
     */
    public function setPersonUpdate(?Person $personUpdate): FinanceFee
    {
        $this->personUpdate = $personUpdate;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampUpdate(): ?\DateTime
    {
        return $this->timestampUpdate;
    }

    /**
     * setTimestampUpdate
     * @param \DateTime|null $timestampUpdate
     * @return FinanceFee
     * @throws \Exception
     * @ORM\PreUpdate()
     */
    public function setTimestampUpdate(?\DateTime $timestampUpdate = null): FinanceFee
    {
        $this->timestampUpdate = $timestampUpdate ?: new \DateTime('now');
        return $this;
    }
}