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
 * Class FinanceInvoice
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceInvoiceRepository")
 * @ORM\Table(name="FinanceInvoice")
 * @ORM\HasLifecycleCallbacks()
 */
class FinanceInvoice
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonFinanceInvoiceID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
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
     * @var FinanceInvoicee|null
     * @ORM\ManyToOne(targetEntity="FinanceInvoicee")
     * @ORM\JoinColumn(name="gibbonFinanceInvoiceeID", referencedColumnName="gibbonFinanceInvoiceeID", nullable=false)
     */
    private $financeInvoicee;

    /**
     * @var string
     * @ORM\Column(length=8, name="invoiceTo", options={"default": "Family"})
     */
    private $invoiceTo = 'Family';

    /**
     * @var array
     */
    private static $invoiceToList = ['Family', 'Company'];

    /**
     * @var string
     * @ORM\Column(length=12, name="billingScheduleType", options={"default": "Ad Hoc"})
     */
    private $billingScheduleType = 'Ad Hoc';

    /**
     * @var array
     */
    private static $billingScheduleTypeList = ['Scheduled', 'Ad Hoc'];

    /**
     * @var string
     * @ORM\Column(length=1, options={"comment": "Has this invoice been separated from its schedule in gibbonFinanceBillingSchedule? Only applies to scheduled invoices. Separation takes place during invoice issueing."}, nullable=true)
     */
    private $separated;

    /**
     * @var FinanceBillingSchedule|null
     * @ORM\ManyToOne(targetEntity="FinanceBillingSchedule")
     * @ORM\JoinColumn(name="gibbonFinanceBillingScheduleID", referencedColumnName="gibbonFinanceBillingScheduleID", nullable=true)
     */
    private $financeBillingSchedule;

    /**
     * @var string
     * @ORM\Column(length=16, options={"default": "Pending"})
     */
    private $status = 'Pending';

    /**
     * @var array
     */
    private static $statusList = ['Pending','Issued','Paid','Paid - Partial','Cancelled','Refunded'];

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true, name="gibbonFinanceFeeCategoryIDList")
     */
    private $financeFeeCategoryList;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true, name="invoiceIssueDate")
     */
    private $invoiceIssueDate;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true, name="invoiceDueDate")
     */
    private $invoiceDueDate;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true, name="paidDate")
     */
    private $paidDate;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=13, scale=2, nullable=true, name="paidAmount", options={"comment": "The current running total amount paid to this invoice"})
     */
    private $paidAmount;

    /**
     * @var Payment|null
     * @ORM\ManyToOne(targetEntity="Payment")
     * @ORM\JoinColumn(name="gibbonPaymentID", referencedColumnName="gibbonPaymentID", nullable=true)
     */
    private $payment;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="reminderCount", columnDefinition="INT(3)", options={"default": "0"})
     */
    private $reminderCount = 0;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $notes;

    /**
     * @var string|null
     * @ORM\Column(length=40)
     */
    private $key;

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
     * @return FinanceInvoice
     */
    public function setId(?int $id): FinanceInvoice
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
     * @return FinanceInvoice
     */
    public function setSchoolYear(?SchoolYear $schoolYear): FinanceInvoice
    {
        $this->schoolYear = $schoolYear;
        return $this;
    }

    /**
     * @return FinanceInvoicee|null
     */
    public function getFinanceInvoicee(): ?FinanceInvoicee
    {
        return $this->financeInvoicee;
    }

    /**
     * @param FinanceInvoicee|null $financeInvoicee
     * @return FinanceInvoice
     */
    public function setFinanceInvoicee(?FinanceInvoicee $financeInvoicee): FinanceInvoice
    {
        $this->financeInvoicee = $financeInvoicee;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceTo(): string
    {
        return $this->invoiceTo;
    }

    /**
     * @param string $invoiceTo
     * @return FinanceInvoice
     */
    public function setInvoiceTo(string $invoiceTo): FinanceInvoice
    {
        $this->invoiceTo = in_array($invoiceTo, self::getInvoiceToList()) ? $invoiceTo : 'Family';
        return $this;
    }

    /**
     * @return string
     */
    public function getBillingScheduleType(): string
    {
        return $this->billingScheduleType;
    }

    /**
     * @param string $billingScheduleType
     * @return FinanceInvoice
     */
    public function setBillingScheduleType(string $billingScheduleType): FinanceInvoice
    {
        $this->billingScheduleType = in_array($billingScheduleType, self::getBillingScheduleTypeList()) ? $billingScheduleType : 'Ad Hoc';
        return $this;
    }

    /**
     * @return string
     */
    public function getSeparated(): string
    {
        return $this->separated;
    }

    /**
     * @param string $separated
     * @return FinanceInvoice
     */
    public function setSeparated(string $separated): FinanceInvoice
    {
        $this->separated = self::checkBoolean($separated, null);
        return $this;
    }

    /**
     * @return FinanceBillingSchedule|null
     */
    public function getFinanceBillingSchedule(): ?FinanceBillingSchedule
    {
        return $this->financeBillingSchedule;
    }

    /**
     * @param FinanceBillingSchedule|null $financeBillingSchedule
     * @return FinanceInvoice
     */
    public function setFinanceBillingSchedule(?FinanceBillingSchedule $financeBillingSchedule): FinanceInvoice
    {
        $this->financeBillingSchedule = $financeBillingSchedule;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return FinanceInvoice
     */
    public function setStatus(string $status): FinanceInvoice
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Pending';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFinanceFeeCategoryList(): ?string
    {
        return $this->financeFeeCategoryList;
    }

    /**
     * @param string|null $financeFeeCategoryList
     * @return FinanceInvoice
     */
    public function setFinanceFeeCategoryList(?string $financeFeeCategoryList): FinanceInvoice
    {
        $this->financeFeeCategoryList = $financeFeeCategoryList;
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
     * @return FinanceInvoice
     */
    public function setInvoiceIssueDate(?\DateTime $invoiceIssueDate): FinanceInvoice
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
     * @return FinanceInvoice
     */
    public function setInvoiceDueDate(?\DateTime $invoiceDueDate): FinanceInvoice
    {
        $this->invoiceDueDate = $invoiceDueDate;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPaidDate(): ?\DateTime
    {
        return $this->paidDate;
    }

    /**
     * @param \DateTime|null $paidDate
     * @return FinanceInvoice
     */
    public function setPaidDate(?\DateTime $paidDate): FinanceInvoice
    {
        $this->paidDate = $paidDate;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPaidAmount(): ?float
    {
        return $this->paidAmount;
    }

    /**
     * @param float|null $paidAmount
     * @return FinanceInvoice
     */
    public function setPaidAmount(?float $paidAmount): FinanceInvoice
    {
        $this->paidAmount = $paidAmount;
        return $this;
    }

    /**
     * @return Payment|null
     */
    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    /**
     * @param Payment|null $payment
     * @return FinanceInvoice
     */
    public function setPayment(?Payment $payment): FinanceInvoice
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getReminderCount(): ?int
    {
        return $this->reminderCount;
    }

    /**
     * @param int|null $reminderCount
     * @return FinanceInvoice
     */
    public function setReminderCount(?int $reminderCount): FinanceInvoice
    {
        $this->reminderCount = $reminderCount;
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
     * @return FinanceInvoice
     */
    public function setNotes(?string $notes): FinanceInvoice
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     * @return FinanceInvoice
     */
    public function setKey(?string $key): FinanceInvoice
    {
        $this->key = $key;
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
     * @return FinanceInvoice
     */
    public function setPersonCreator(?Person $personCreator): FinanceInvoice
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
     * @return FinanceInvoice
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestampCreator(?\DateTime $timestampCreator = null): FinanceInvoice
    {
        $this->timestampCreator = $timestampCreator ?: new \DateTime('now');
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
     * @return FinanceInvoice
     */
    public function setPersonUpdate(?Person $personUpdate): FinanceInvoice
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
     * @return FinanceInvoice
     * @throws \Exception
     * @ORM\PreUpdate()
     */
    public function setTimestampUpdate(?\DateTime $timestampUpdate = null): FinanceInvoice
    {
        $this->timestampUpdate = $timestampUpdate ?: new \DateTime('now');
        return $this;
    }

    /**
     * @return array
     */
    public static function getInvoiceToList(): array
    {
        return self::$invoiceToList;
    }

    /**
     * @return array
     */
    public static function getBillingScheduleTypeList(): array
    {
        return self::$billingScheduleTypeList;
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }
}