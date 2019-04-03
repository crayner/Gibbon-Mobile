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
 * Class FinanceInvoicee
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceInvoiceeRepository")
 * @ORM\Table(name="FinanceInvoicee")
 */
class FinanceInvoicee
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonFinanceInvoiceeID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FinanceInvoicee
     */
    public function setId(?int $id): FinanceInvoicee
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
     * @return FinanceInvoicee
     */
    public function setPerson(?Person $person): FinanceInvoicee
    {
        $this->person = $person;
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
     * @return FinanceInvoicee
     */
    public function setInvoiceTo(string $invoiceTo): FinanceInvoicee
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
     * @return FinanceInvoicee
     */
    public function setCompanyName(?string $companyName): FinanceInvoicee
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
     * @return FinanceInvoicee
     */
    public function setCompanyContact(?string $companyContact): FinanceInvoicee
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
     * @return FinanceInvoicee
     */
    public function setCompanyAddress(?string $companyAddress): FinanceInvoicee
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
     * @return FinanceInvoicee
     */
    public function setCompanyEmail(?string $companyEmail): FinanceInvoicee
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
     * @return FinanceInvoicee
     */
    public function setCompanyCCFamily(?string $companyCCFamily): FinanceInvoicee
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
     * @return FinanceInvoicee
     */
    public function setCompanyPhone(?string $companyPhone): FinanceInvoicee
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
     * @return FinanceInvoicee
     */
    public function setCompanyAll(?string $companyAll): FinanceInvoicee
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
     * @return FinanceInvoicee
     */
    public function setFinanceFeeCategoryList(?string $financeFeeCategoryList): FinanceInvoicee
    {
        $this->financeFeeCategoryList = $financeFeeCategoryList;
        return $this;
    }

    /**
     * @return array
     */
    public static function getInvoiceToList(): array
    {
        return FinanceInvoice::getInvoiceToList();
    }
}