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
 * Class CrowdAssessDiscuss
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CrowdAssessDiscussRepository")
 * @ORM\Table(name="CrowdAssessDiscuss")
 * @ORM\HasLifecycleCallbacks
 */
class CrowdAssessDiscuss
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonCrowdAssessDiscussID", columnDefinition="INT(16) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var PlannerEntryHomework|null
     * @ORM\ManyToOne(targetEntity="PlannerEntryHomework")
     * @ORM\JoinColumn(name="gibbonPlannerEntryHomeworkID", referencedColumnName="gibbonPlannerEntryHomeworkID")
     */
    private $plannerEntryHomework;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestamp;

    /**
     * @var string|null
     * @ORM\Column(type="text", options={"current_timestamp()"})
     */
    private $comment;

    /**
     * @var CrowdAssessDiscuss|null
     * @ORM\ManyToOne(targetEntity="CrowdAssessDiscuss")
     * @ORM\JoinColumn(name="gibbonCrowdAssessDiscussIDReplyTo", referencedColumnName="gibbonCrowdAssessDiscussID")
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
     * @return CrowdAssessDiscuss
     */
    public function setId(?int $id): CrowdAssessDiscuss
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return PlannerEntryHomework|null
     */
    public function getPlannerEntryHomework(): ?PlannerEntryHomework
    {
        return $this->plannerEntryHomework;
    }

    /**
     * @param PlannerEntryHomework|null $plannerEntryHomework
     * @return CrowdAssessDiscuss
     */
    public function setPlannerEntryHomework(?PlannerEntryHomework $plannerEntryHomework): CrowdAssessDiscuss
    {
        $this->plannerEntryHomework = $plannerEntryHomework;
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
     * @return CrowdAssessDiscuss
     */
    public function setPerson(?Person $person): CrowdAssessDiscuss
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
     * @return CrowdAssessDiscuss
     * @ORM\PrePersist()
     */
    public function setTimestamp(?\DateTime $timestamp = null): CrowdAssessDiscuss
    {
        $this->timestamp = $timestamp ?: new \DateTime('now');
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
     * @return CrowdAssessDiscuss
     */
    public function setComment(?string $comment): CrowdAssessDiscuss
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return CrowdAssessDiscuss|null
     */
    public function getReplyTo(): ?CrowdAssessDiscuss
    {
        return $this->replyTo;
    }

    /**
     * @param CrowdAssessDiscuss|null $replyTo
     * @return CrowdAssessDiscuss
     */
    public function setReplyTo(?CrowdAssessDiscuss $replyTo): CrowdAssessDiscuss
    {
        $this->replyTo = $replyTo;
        return $this;
    }
}