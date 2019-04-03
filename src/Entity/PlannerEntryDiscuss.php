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
 * Class PlannerEntryDiscuss
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PlannerEntryDiscussRepository")
 * @ORM\Table(name="PlannerEntryDiscuss")
 * @ORM\HasLifecycleCallbacks()
 */
class PlannerEntryDiscuss
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonPlannerEntryDiscussID", columnDefinition="INT(16) UNSIGNED ZEROFILL")
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
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestamp;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @var PlannerEntryDiscuss|null
     * @ORM\ManyToOne(targetEntity="PlannerEntryDiscuss")
     * @ORM\JoinColumn(name="gibbonPlannerEntryDiscussIDReplyTo", referencedColumnName="gibbonPlannerEntryDiscussID", nullable=true)
     */
    private $replyTo;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PlannerEntryDiscuss
     */
    public function setId(?int $id): PlannerEntryDiscuss
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
     * @return PlannerEntryDiscuss
     */
    public function setPlannerEntry(?PlannerEntry $plannerEntry): PlannerEntryDiscuss
    {
        $this->plannerEntry = $plannerEntry;
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
     * @return PlannerEntryDiscuss
     */
    public function setPerson(?Person $person): PlannerEntryDiscuss
    {
        $this->person = $person;
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
     * @return PlannerEntryDiscuss
     */
    public function setTimestamp(?\DateTime $timestamp): PlannerEntryDiscuss
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return PlannerEntryDiscuss
     */
    public function setComment(?string $comment): PlannerEntryDiscuss
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return PlannerEntryDiscuss|null
     */
    public function getReplyTo(): ?PlannerEntryDiscuss
    {
        return $this->replyTo;
    }

    /**
     * @param PlannerEntryDiscuss|null $replyTo
     * @return PlannerEntryDiscuss
     */
    public function setReplyTo(?PlannerEntryDiscuss $replyTo): PlannerEntryDiscuss
    {
        $this->replyTo = $replyTo;
        return $this;
    }
}