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
 * Class FinanceBudgetCycleAllocation
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceBudgetCycleAllocationRepository")
 * @ORM\Table(name="FinanceBudgetCycleAllocation")
 */
class FinanceBudgetCycleAllocation
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonFinanceBudgetCycleAllocationID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
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
     * @var float
     * @ORM\Column(type="decimal", precision=14, scale=2, options={"default": "0.00"})
     */
    private $value = 0.00;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FinanceBudgetCycleAllocation
     */
    public function setId(?int $id): FinanceBudgetCycleAllocation
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
     * @return FinanceBudgetCycleAllocation
     */
    public function setFinanceBudget(?FinanceBudget $financeBudget): FinanceBudgetCycleAllocation
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
     * @return FinanceBudgetCycleAllocation
     */
    public function setFinanceBudgetCycle(?FinanceBudgetCycle $financeBudgetCycle): FinanceBudgetCycleAllocation
    {
        $this->financeBudgetCycle = $financeBudgetCycle;
        return $this;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return FinanceBudgetCycleAllocation
     */
    public function setValue(float $value): FinanceBudgetCycleAllocation
    {
        $this->value = number_format($value, 2);
        return $this;
    }
}