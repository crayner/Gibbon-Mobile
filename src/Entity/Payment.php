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
 * Class Payment
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 * @ORM\Table(name="Payment")
 */
class Payment
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonPaymentID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="foreignTable")
     */
    private $foreignTable;

    /**
     * @var integer|null
     * @ORM\Column(type="bigint", name="foreignTableID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     */
    private $foreignTableID;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID")
     * Person recording the transaction
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=16, options={"default": "Online"})
     */
    private $type = 'Online';

    /**
     * @var array
     */
    private static $typeList = ['Online','Bank Transfer','Cash','Cheque','Other','Credit Card'];

    /**
     * @var string|null
     * @ORM\Column(length=8, options={"comment": "Complete means paid in one go, partial is part of a set of payments, and final is last in a set of payments.", "default": "Complete"})
     */
    private $status = 'Complete';

    /**
     * @var array
     */
    private static $statusList = ['Complete','Partial','Final','Failure'];

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    private $amount;

    /**
     * @var string|null
     * @ORM\Column(length=6, nullable=true)
     */
    private $gateway = 'Paypal';

    /**
     * @var string|null
     * @ORM\Column(length=12, name="onlineTransactionStatus", nullable=true)
     */
    private $onlineTransactionStatus;

    /**
     * @var array
     */
    private static $onlineTransactionStatusList = ['Success', 'Failure'];

    /**
     * @var string|null
     * @ORM\Column(length=50, name="paymentToken", nullable=true)
     */
    private $paymentToken;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="paymentPayerID", nullable=true)
     */
    private $paymentPayerID;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="paymentTransactionID", nullable=true)
     */
    private $paymentTransactionID;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="paymentReceiptID", nullable=true)
     */
    private $paymentReceiptID;

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
     * @return Payment
     */
    public function setId(?int $id): Payment
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getForeignTable(): ?string
    {
        return $this->foreignTable;
    }

    /**
     * @param string|null $foreignTable
     * @return Payment
     */
    public function setForeignTable(?string $foreignTable): Payment
    {
        $this->foreignTable = $foreignTable;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getForeignTableID(): ?int
    {
        return $this->foreignTableID;
    }

    /**
     * @param int|null $foreignTableID
     * @return Payment
     */
    public function setForeignTableID(?int $foreignTableID): Payment
    {
        $this->foreignTableID = $foreignTableID;
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
     * @return Payment
     */
    public function setPerson(?Person $person): Payment
    {
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
     * @return Payment
     */
    public function setType(?string $type): Payment
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : 'Online' ;
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
     * @return Payment
     */
    public function setStatus(?string $status): Payment
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Complete';
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     * @return Payment
     */
    public function setAmount(?float $amount): Payment
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGateway(): ?string
    {
        return $this->gateway;
    }

    /**
     * @param string|null $gateway
     * @return Payment
     */
    public function setGateway(?string $gateway): Payment
    {
        $this->gateway = $gateway ? 'Paypal' : null;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOnlineTransactionStatus(): ?string
    {
        return $this->onlineTransactionStatus;
    }

    /**
     * @param string|null $onlineTransactionStatus
     * @return Payment
     */
    public function setOnlineTransactionStatus(?string $onlineTransactionStatus): Payment
    {
        $this->onlineTransactionStatus = in_array($onlineTransactionStatus, self::getOnlineTransactionStatusList()) ? $onlineTransactionStatus : null;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentToken(): ?string
    {
        return $this->paymentToken;
    }

    /**
     * @param string|null $paymentToken
     * @return Payment
     */
    public function setPaymentToken(?string $paymentToken): Payment
    {
        $this->paymentToken = $paymentToken;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentPayerID(): ?string
    {
        return $this->paymentPayerID;
    }

    /**
     * @param string|null $paymentPayerID
     * @return Payment
     */
    public function setPaymentPayerID(?string $paymentPayerID): Payment
    {
        $this->paymentPayerID = $paymentPayerID;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentTransactionID(): ?string
    {
        return $this->paymentTransactionID;
    }

    /**
     * @param string|null $paymentTransactionID
     * @return Payment
     */
    public function setPaymentTransactionID(?string $paymentTransactionID): Payment
    {
        $this->paymentTransactionID = $paymentTransactionID;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentReceiptID(): ?string
    {
        return $this->paymentReceiptID;
    }

    /**
     * @param string|null $paymentReceiptID
     * @return Payment
     */
    public function setPaymentReceiptID(?string $paymentReceiptID): Payment
    {
        $this->paymentReceiptID = $paymentReceiptID;
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
     * @param \DateTime|null $timestamp
     * @return Payment
     */
    public function setTimestamp(?\DateTime $timestamp): Payment
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return array
     */
    public static function getTypeList(): array
    {
        return self::$typeList;
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
    public static function getOnlineTransactionStatusList(): array
    {
        return self::$onlineTransactionStatusList;
    }
}