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
 * Class FinanceExpense
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceExpenseRepository")
 * @ORM\Table(name="FinanceExpense")
 * @ORM\HasLifecycleCallbacks
 */
class FinanceExpense
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonFinanceExpenseID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var FinanceBudget|null
     * @ORM\ManyToOne(targetEntity="FinanceBudget")
     * @ORM\JoinColumn(name="gibbonFinanceBudgetID", referencedColumnName="gibbonFinanceBudgetID", nullable=false)
     */
    private $financeBudget;

    /**
     * @var FinanceBudgetCycle|null
     * @ORM\ManyToOne(targetEntity="FinanceBudgetCycle")
     * @ORM\JoinColumn(name="gibbonFinanceBudgetCycleID", referencedColumnName="gibbonFinanceBudgetCycleID", nullable=false)
     */
    private $financeBudgetCycle;

    /**
     * @var string|null
     * @ORM\Column(length=60)
     */
    private $title ;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $body ;

    /**
     * @var string|null
     * @ORM\Column(length=10)
     */
    private $status ;

    /**
     * @var array
     */
    private static $statusList = ['Requested','Approved','Rejected','Cancelled','Ordered','Paid'];

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $cost;

    /**
     * @var string
     * @ORM\Column(length=1, name="countAgainstBudget", options={"default": "Y"})
     */
    private $countAgainstBudget = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=6, name="purchaseBy", options={"default": "School"})
     */
    private $purchaseBy = 'School';

    /**
     * @var array
     */
    private static $purchaseByList = ['School', 'Self'];

    /**
     * @var string|null
     * @ORM\Column(type="text", name="purchaseDetails")
     */
    private $purchaseDetails;

    /**
     * @var string|null
     * @ORM\Column(length=16, nullable=true, name="paymentMethod")
     */
    private $paymentMethod;

    /**
     * @var array
     */
    private static $paymentMethodList = ['Cash','Cheque','Credit Card','Bank Transfer','Other'];

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=true, name="paymentDate")
     */
    private $paymentDate;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true, name="paymentAmount")
     */
    private $paymentAmount;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDPayment", referencedColumnName="gibbonPersonID")
     */
    private $personPayment;

    /**
     * @var string|null
     * @ORM\Column(length=100, nullable=true, name="paymentID")
     */
    private $paymentID;

    /**
     * @var string|null
     * @ORM\Column(name="paymentReimbursementReceipt")
     */
    private $paymentReimbursementReceipt;

    /**
     * @var string|null
     * @ORM\Column(length=10, nullable=true, name="paymentReimbursementStatus")
     */
    private $paymentReimbursementStatus;

    /**
     * @var array
     */
    private static $paymentReimbursementStatusList = ['Requested', 'Complete'];

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
     * @var string
     * @ORM\Column(length=1, name="statusApprovalBudgetCleared", options={"default": "N"})
     */
    private $statusApprovalBudgetCleared = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FinanceExpense
     */
    public function setId(?int $id): FinanceExpense
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return FinanceBudget|null
     */
    public function getFinanceBudget(): ?FinanceBudget
    {
        return $this->financeBudget;
    }

    /**
     * @param FinanceBudget|null $financeBudget
     * @return FinanceExpense
     */
    public function setFinanceBudget(?FinanceBudget $financeBudget): FinanceExpense
    {
        $this->financeBudget = $financeBudget;
        return $this;
    }

    /**
     * @return FinanceBudgetCycle|null
     */
    public function getFinanceBudgetCycle(): ?FinanceBudgetCycle
    {
        return $this->financeBudgetCycle;
    }

    /**
     * @param FinanceBudgetCycle|null $financeBudgetCycle
     * @return FinanceExpense
     */
    public function setFinanceBudgetCycle(?FinanceBudgetCycle $financeBudgetCycle): FinanceExpense
    {
        $this->financeBudgetCycle = $financeBudgetCycle;
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
     * @return FinanceExpense
     */
    public function setTitle(?string $title): FinanceExpense
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     * @return FinanceExpense
     */
    public function setBody(?string $body): FinanceExpense
    {
        $this->body = $body;
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
     * @return FinanceExpense
     */
    public function setStatus(?string $status): FinanceExpense
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : null;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCost(): ?float
    {
        return $this->cost;
    }

    /**
     * @param float|null $cost
     * @return FinanceExpense
     */
    public function setCost(?float $cost): FinanceExpense
    {
        $this->cost = number_format($cost, 2);
        return $this;
    }

    /**
     * @return string
     */
    public function getCountAgainstBudget(): string
    {
        return $this->countAgainstBudget;
    }

    /**
     * @param string $countAgainstBudget
     * @return FinanceExpense
     */
    public function setCountAgainstBudget(string $countAgainstBudget): FinanceExpense
    {
        $this->countAgainstBudget = self::checkBoolean($countAgainstBudget, "Y");
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPurchaseBy(): ?string
    {
        return $this->purchaseBy;
    }

    /**
     * @param string|null $purchaseBy
     * @return FinanceExpense
     */
    public function setPurchaseBy(?string $purchaseBy): FinanceExpense
    {
        $this->purchaseBy = in_array($purchaseBy, self::getPurchaseByList()) ? $purchaseBy : "School";
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPurchaseDetails(): ?string
    {
        return $this->purchaseDetails;
    }

    /**
     * @param string|null $purchaseDetails
     * @return FinanceExpense
     */
    public function setPurchaseDetails(?string $purchaseDetails): FinanceExpense
    {
        $this->purchaseDetails = $purchaseDetails;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    /**
     * @param string|null $paymentMethod
     * @return FinanceExpense
     */
    public function setPaymentMethod(?string $paymentMethod): FinanceExpense
    {
        $this->paymentMethod = in_array($paymentMethod, self::getPaymentMethodList()) ? $paymentMethod : null ;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPaymentDate(): ?\DateTime
    {
        return $this->paymentDate;
    }

    /**
     * @param \DateTime|null $paymentDate
     * @return FinanceExpense
     */
    public function setPaymentDate(?\DateTime $paymentDate): FinanceExpense
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPaymentAmount(): ?float
    {
        return $this->paymentAmount;
    }

    /**
     * @param float|null $paymentAmount
     * @return FinanceExpense
     */
    public function setPaymentAmount(?float $paymentAmount): FinanceExpense
    {
        $this->paymentAmount = number_format($paymentAmount, 2);
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonPayment(): ?Person
    {
        return $this->personPayment;
    }

    /**
     * @param Person|null $personPayment
     * @return FinanceExpense
     */
    public function setPersonPayment(?Person $personPayment): FinanceExpense
    {
        $this->personPayment = $personPayment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentID(): ?string
    {
        return $this->paymentID;
    }

    /**
     * @param string|null $paymentID
     * @return FinanceExpense
     */
    public function setPaymentID(?string $paymentID): FinanceExpense
    {
        $this->paymentID = $paymentID;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentReimbursementReceipt(): ?string
    {
        return $this->paymentReimbursementReceipt;
    }

    /**
     * @param string|null $paymentReimbursementReceipt
     * @return FinanceExpense
     */
    public function setPaymentReimbursementReceipt(?string $paymentReimbursementReceipt): FinanceExpense
    {
        $this->paymentReimbursementReceipt = $paymentReimbursementReceipt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentReimbursementStatus(): ?string
    {
        return $this->paymentReimbursementStatus;
    }

    /**
     * @param string|null $paymentReimbursementStatus
     * @return FinanceExpense
     */
    public function setPaymentReimbursementStatus(?string $paymentReimbursementStatus): FinanceExpense
    {
        $this->paymentReimbursementStatus = in_array($paymentReimbursementStatus, self::getPaymentReimbursementStatusList()) ? $paymentReimbursementStatus : null ;
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
     * @return FinanceExpense
     */
    public function setPersonCreator(?Person $personCreator): FinanceExpense
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
     * @return FinanceExpense
     * @throws \Exception
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setTimestampCreator(?\DateTime $timestampCreator = null): FinanceExpense
    {
        $this->timestampCreator = $timestampCreator ?: new \DateTime('now');
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusApprovalBudgetCleared(): string
    {
        return $this->statusApprovalBudgetCleared;
    }

    /**
     * @param string $statusApprovalBudgetCleared
     * @return FinanceExpense
     */
    public function setStatusApprovalBudgetCleared(string $statusApprovalBudgetCleared): FinanceExpense
    {
        $this->statusApprovalBudgetCleared = self::checkBoolean($statusApprovalBudgetCleared, 'N');
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
    public static function getPurchaseByList(): array
    {
        return self::$purchaseByList;
    }

    /**
     * @return array
     */
    public static function getPaymentMethodList(): array
    {
        return self::$paymentMethodList;
    }

    /**
     * @return array
     */
    public static function getPaymentReimbursementStatusList(): array
    {
        return self::$paymentReimbursementStatusList;
    }
}