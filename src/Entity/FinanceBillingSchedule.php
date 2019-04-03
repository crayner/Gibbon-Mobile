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
 * Class FinanceBillingSchedule
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceBillingScheduleRepository")
 * @ORM\Table(name="FinanceBillingSchedule")
 */
class FinanceBillingSchedule
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonFinanceBillingScheduleID", columnDefinition="INT(6) UNSIGNED ZEROFILL")
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $active = 'Y';

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="invoiceIssueDate", nullable=true)
     */
    private $invoiceIssueDate;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="invoiceDueDate", nullable=true)
     */
    private $invoiceDueDate;

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
    private $personUpdater;

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
     * @return FinanceBillingSchedule
     */
    public function setId(?int $id): FinanceBillingSchedule
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
     * @return FinanceBillingSchedule
     */
    public function setSchoolYear(?SchoolYear $schoolYear): FinanceBillingSchedule
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
     * @return FinanceBillingSchedule
     */
    public function setName(?string $name): FinanceBillingSchedule
    {
        $this->name = $name;
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
     * @return FinanceBillingSchedule
     */
    public function setDescription(?string $description): FinanceBillingSchedule
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
     * setActive
     * @param string|null $active
     * @return FinanceBillingSchedule
     */
    public function setActive(?string $active): FinanceBillingSchedule
    {
        $this->active = self::checkBoolean($active, 'Y');
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getInvoiceIssueDate(): ?\DateTime
    {
        return $this->invoiceIssueDate;
    }

    /**
     * @param \DateTime|null $invoiceIssueDate
     * @return FinanceBillingSchedule
     */
    public function setInvoiceIssueDate(?\DateTime $invoiceIssueDate): FinanceBillingSchedule
    {
        $this->invoiceIssueDate = $invoiceIssueDate;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getInvoiceDueDate(): ?\DateTime
    {
        return $this->invoiceDueDate;
    }

    /**
     * @param \DateTime|null $invoiceDueDate
     * @return FinanceBillingSchedule
     */
    public function setInvoiceDueDate(?\DateTime $invoiceDueDate): FinanceBillingSchedule
    {
        $this->invoiceDueDate = $invoiceDueDate;
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
     * @return FinanceBillingSchedule
     */
    public function setPersonCreator(?Person $personCreator): FinanceBillingSchedule
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
     * @return FinanceBillingSchedule
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestampCreator(?\DateTime $timestampCreator = null): FinanceBillingSchedule
    {
        $this->timestampCreator = $timestampCreator ?: new \DateTime('now');
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
     * @return FinanceBillingSchedule
     */
    public function setPersonUpdater(?Person $personUpdater): FinanceBillingSchedule
    {
        $this->personUpdater = $personUpdater;
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
     * @return FinanceBillingSchedule
     * @throws \Exception
     * @ORM\PreUpdate()
     */
    public function setTimestampUpdate(?\DateTime $timestampUpdate = null): FinanceBillingSchedule
    {
        $this->timestampUpdate = $timestampUpdate ?: new \DateTime('now');
        return $this;
    }
}