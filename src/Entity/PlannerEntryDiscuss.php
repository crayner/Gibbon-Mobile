<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon, Flexible & Open School System
 * Copyright (C) 2010, Ross Parker
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the LICENCE file.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * Gibbon-Mobile
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
     * @ORM\JoinColumn(name="gibbonPlannerEntryID", referencedColumnName="gibbonPlannerEntryID")
     */
    private $plannerEntry;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=true)
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