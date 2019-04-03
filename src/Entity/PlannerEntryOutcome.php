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
 * Class PlannerEntryOutcome
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PlannerEntryOutcomeRepository")
 * @ORM\Table(name="PlannerEntryOutcome")
 */
class PlannerEntryOutcome
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonPlannerEntryOutcomeID", columnDefinition="INT(16) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var PlannerEntry|null
     * @ORM\ManyToOne(targetEntity="PlannerEntry")
     * @ORM\JoinColumn(name="gibbonPlannerEntryID", referencedColumnName="gibbonPlannerEntryID", nullable=false)
     */
    private $plannerEntry;

    /**
     * @var Outcome|null
     * @ORM\ManyToOne(targetEntity="Outcome")
     * @ORM\JoinColumn(name="gibbonOutcomeID", referencedColumnName="gibbonOutcomeID", nullable=false)
     */
    private $outcome;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="sequenceNumber", columnDefinition="INT(4)")
     */
    private $sequenceNumber;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PlannerEntryOutcome
     */
    public function setId(?int $id): PlannerEntryOutcome
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return PlannerEntry|null
     */
    public function getPlannerEntry(): ?PlannerEntry
    {
        return $this->plannerEntry;
    }

    /**
     * @param PlannerEntry|null $plannerEntry
     * @return PlannerEntryOutcome
     */
    public function setPlannerEntry(?PlannerEntry $plannerEntry): PlannerEntryOutcome
    {
        $this->plannerEntry = $plannerEntry;
        return $this;
    }

    /**
     * @return Outcome|null
     */
    public function getOutcome(): ?Outcome
    {
        return $this->outcome;
    }

    /**
     * @param Outcome|null $outcome
     * @return PlannerEntryOutcome
     */
    public function setOutcome(?Outcome $outcome): PlannerEntryOutcome
    {
        $this->outcome = $outcome;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int|null $sequenceNumber
     * @return PlannerEntryOutcome
     */
    public function setSequenceNumber(?int $sequenceNumber): PlannerEntryOutcome
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return PlannerEntryOutcome
     */
    public function setContent(?string $content): PlannerEntryOutcome
    {
        $this->content = $content;
        return $this;
    }
}