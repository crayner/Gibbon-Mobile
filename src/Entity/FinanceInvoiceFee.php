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
 * Class FinanceInvoiceFee
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceInvoiceFeeRepository")
 * @ORM\Table(name="FinanceInvoiceFee")
 */
class FinanceInvoiceFee
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonFinanceInvoiceFeeID", columnDefinition="INT(15) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var FinanceInvoice|null
     * @ORM\ManyToOne(targetEntity="FinanceInvoice")
     * @ORM\JoinColumn(name="gibbonFinanceInvoiceID", referencedColumnName="gibbonFinanceInvoiceID", nullable=false)
     */
    private $financeInvoice;

    /**
     * @var string
     * @ORM\Column(length=12, name="feeType", options={"default": "Ad Hoc"})
     */
    private $feeType = 'Ad Hoc';

    /**
     * @var FinanceFee|null
     * @ORM\ManyToOne(targetEntity="FinanceFee")
     * @ORM\JoinColumn(name="gibbonFinanceFeeID", referencedColumnName="gibbonFinanceFeeID", nullable=true, columnDefinition="INT(6) UNSIGNED ZEROFILL")
     */
    private $financeFee;

    /**
     * @var string|null
     * @ORM\Column(length=1, nullable=true, options={"comment": "Has this fee been separated from its parent in gibbonFinanceFee? Only applies to Standard fees. Separation takes place during invoice issueing."})
     */
    private $separated;

    /**
     * @var string|null
     * @ORM\Column(length=100, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var FinanceFeeCategory|null
     * @ORM\ManyToOne(targetEntity="FinanceFeeCategory")
     * @ORM\JoinColumn(name="gibbonFinanceFeeCategoryID", referencedColumnName="gibbonFinanceFeeCategoryID", nullable=true, columnDefinition="INT(6) UNSIGNED ZEROFILL")
     */
    private $financeFeeCategory;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    private $fee;

    /**
     * @var string|null
     * @ORM\Column(type="integer", name="sequenceNumber", nullable=true, columnDefinition="INT(10)")
     */
    private $sequenceNumber;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FinanceInvoiceFee
     */
    public function setId(?int $id): FinanceInvoiceFee
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return FinanceInvoice|null
     */
    public function getFinanceInvoice(): ?FinanceInvoice
    {
        return $this->financeInvoice;
    }

    /**
     * @param FinanceInvoice|null $financeInvoice
     * @return FinanceInvoiceFee
     */
    public function setFinanceInvoice(?FinanceInvoice $financeInvoice): FinanceInvoiceFee
    {
        $this->financeInvoice = $financeInvoice;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeeType(): string
    {
        return $this->feeType;
    }

    /**
     * setFeeType
     * @param string $feeType
     * @return FinanceInvoiceFee
     */
    public function setFeeType(string $feeType): FinanceInvoiceFee
    {
        $this->feeType = in_array($feeType, self::getFeeTypelist()) ? $feeType : 'Ad Hoc';
        return $this;
    }

    /**
     * @return FinanceFee|null
     */
    public function getFinanceFee(): ?FinanceFee
    {
        return $this->financeFee;
    }

    /**
     * @param FinanceFee|null $financeFee
     * @return FinanceInvoiceFee
     */
    public function setFinanceFee(?FinanceFee $financeFee): FinanceInvoiceFee
    {
        $this->financeFee = $financeFee;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSeparated(): ?string
    {
        return $this->separated;
    }

    /**
     * @param string|null $separated
     * @return FinanceInvoiceFee
     */
    public function setSeparated(?string $separated): FinanceInvoiceFee
    {
        $this->separated = self::checkBoolean($separated, null);
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
     * @return FinanceInvoiceFee
     */
    public function setName(?string $name): FinanceInvoiceFee
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
     * @return FinanceInvoiceFee
     */
    public function setDescription(?string $description): FinanceInvoiceFee
    {
        $this->description = $description;
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
     * @return FinanceInvoiceFee
     */
    public function setFinanceFeeCategory(?FinanceFeeCategory $financeFeeCategory): FinanceInvoiceFee
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
     * @return FinanceInvoiceFee
     */
    public function setFee(?float $fee): FinanceInvoiceFee
    {
        $this->fee = number_format($fee, 2);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSequenceNumber(): ?string
    {
        return $this->sequenceNumber;
    }

    /**
     * @param string|null $sequenceNumber
     * @return FinanceInvoiceFee
     */
    public function setSequenceNumber(?string $sequenceNumber): FinanceInvoiceFee
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * getFeeTypelist
     * @return array
     */
    public static function getFeeTypelist(){
        return FinanceInvoice::getBillingScheduleTypeList();
    }
}