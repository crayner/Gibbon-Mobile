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
 * Class FinanceInvoiceeUpdate
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceInvoiceeUpdateRepository")
 * @ORM\Table(name="FinanceInvoiceeUpdate", indexes={@ORM\Index(name="gibbonInvoiceeIndex", columns={"gibbonFinanceInvoiceeID", "gibbonSchoolYearID"})})
 * @ORM\HasLifecycleCallbacks()
 */
class FinanceInvoiceeUpdate
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonFinanceInvoiceeUpdateID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=true)
     */
    private $schoolYear;

    /**
     * @var string
     * @ORM\Column(length=8, options={"default": "Pending"})
     */
    private $status = 'Pending';

    /**
     * @var array
     */
    private static $statusList = ['Pending', 'Complete'];

    /**
     * @var FinanceInvoicee|null
     * @ORM\ManyToOne(targetEntity="FinanceInvoicee")
     * @ORM\JoinColumn(name="gibbonFinanceInvoiceeID", referencedColumnName="gibbonFinanceInvoiceeID", nullable=false)
     */
    private $financeInvoicee;

    /**
     * @var string
     * @ORM\Column(length=8, name="invoiceTo")
     */
    private $invoiceTo = 'Company';

    /**
     * @var string|null
     * @ORM\Column(length=100, name="companyName", nullable=true)
     */
    private $companyName;

    /**
     * @var string|null
     * @ORM\Column(length=100, name="companyContact", nullable=true)
     */
    private $companyContact;

    /**
     * @var string|null
     * @ORM\Column(name="companyAddress", nullable=true)
     */
    private $companyAddress;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="companyEmail", nullable=true)
     */
    private $companyEmail;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="companyCCFamily", nullable=true, options={"comment": "When company is billed, should family receive a copy?"})
     */
    private $companyCCFamily;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="companyPhone", nullable=true)
     */
    private $companyPhone;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="companyAll", nullable=true, options={"comment": "Should company pay all invoices?."})
     */
    private $companyAll;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="gibbonFinanceFeeCategoryIDList", nullable=true, options={"comment": "If companyAll is N, list category IDs for campany to pay here."})
     */
    private $financeFeeCategoryList;

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
     * @return FinanceInvoiceeUpdate
     */
    public function setId(?int $id): FinanceInvoiceeUpdate
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
     * @return FinanceInvoiceeUpdate
     */
    public function setSchoolYear(?SchoolYear $schoolYear): FinanceInvoiceeUpdate
    {
        $this->schoolYear = $schoolYear;
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
     * @return FinanceInvoiceeUpdate
     */
    public function setStatus(string $status): FinanceInvoiceeUpdate
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Pending';
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
     * @return FinanceInvoiceeUpdate
     */
    public function setFinanceInvoicee(?FinanceInvoicee $financeInvoicee): FinanceInvoiceeUpdate
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
     * @return FinanceInvoiceeUpdate
     */
    public function setInvoiceTo(string $invoiceTo): FinanceInvoiceeUpdate
    {
        $this->invoiceTo = in_array($invoiceTo, self::getInvoiceToList()) ? $invoiceTo : 'Company';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string|null $companyName
     * @return FinanceInvoiceeUpdate
     */
    public function setCompanyName(?string $companyName): FinanceInvoiceeUpdate
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyContact(): ?string
    {
        return $this->companyContact;
    }

    /**
     * @param string|null $companyContact
     * @return FinanceInvoiceeUpdate
     */
    public function setCompanyContact(?string $companyContact): FinanceInvoiceeUpdate
    {
        $this->companyContact = $companyContact;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyAddress(): ?string
    {
        return $this->companyAddress;
    }

    /**
     * @param string|null $companyAddress
     * @return FinanceInvoiceeUpdate
     */
    public function setCompanyAddress(?string $companyAddress): FinanceInvoiceeUpdate
    {
        $this->companyAddress = $companyAddress;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyEmail(): ?string
    {
        return $this->companyEmail;
    }

    /**
     * @param string|null $companyEmail
     * @return FinanceInvoiceeUpdate
     */
    public function setCompanyEmail(?string $companyEmail): FinanceInvoiceeUpdate
    {
        $this->companyEmail = $companyEmail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyCCFamily(): ?string
    {
        return $this->companyCCFamily;
    }

    /**
     * @param string|null $companyCCFamily
     * @return FinanceInvoiceeUpdate
     */
    public function setCompanyCCFamily(?string $companyCCFamily): FinanceInvoiceeUpdate
    {
        $this->companyCCFamily = self::checkBoolean($companyCCFamily, null);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyPhone(): ?string
    {
        return $this->companyPhone;
    }

    /**
     * @param string|null $companyPhone
     * @return FinanceInvoiceeUpdate
     */
    public function setCompanyPhone(?string $companyPhone): FinanceInvoiceeUpdate
    {
        $this->companyPhone = $companyPhone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyAll(): ?string
    {
        return $this->companyAll;
    }

    /**
     * @param string|null $companyAll
     * @return FinanceInvoiceeUpdate
     */
    public function setCompanyAll(?string $companyAll): FinanceInvoiceeUpdate
    {
        $this->companyAll = self::checkBoolean($companyAll, null);
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
     * @return FinanceInvoiceeUpdate
     */
    public function setFinanceFeeCategoryList(?string $financeFeeCategoryList): FinanceInvoiceeUpdate
    {
        $this->financeFeeCategoryList = $financeFeeCategoryList;
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
     * @return FinanceInvoiceeUpdate
     */
    public function setPersonUpdater(?Person $personUpdater): FinanceInvoiceeUpdate
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
     * setTimestamp
     * @param \DateTime|null $timestamp
     * @return FinanceInvoiceeUpdate
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestamp(?\DateTime $timestamp = null): FinanceInvoiceeUpdate
    {
        $this->timestamp = $timestamp ?: new \DateTime('now');
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
     * getInvoiceToList
     * @return array
     */
    public static function getInvoiceToList(): array
    {
        return FinanceInvoice::getInvoiceToList();
    }
}