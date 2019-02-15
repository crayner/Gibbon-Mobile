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
 * Class Like
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 * @ORM\Table(name="Like", indexes={@ORM\Index(name="gibbonModuleID", columns={"gibbonModuleID"}), @ORM\Index(name="gibbonPersonIDRecipient", columns={"gibbonPersonIDRecipient"}), @ORM\Index(name="gibbonPersonIDGiver", columns={"gibbonPersonIDGiver"}), @ORM\Index(name="contextKeyNameValue", columns={"contextKeyName","contextKeyValue"})})
 * @ORM\HasLifecycleCallbacks()
 */
class Like
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonLikeID", columnDefinition="INT(16) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=false)
     */
    private $schoolYear;

    /**
     * @var Module|null
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumn(name="gibbonModuleID",referencedColumnName="gibbonModuleID", nullable=false)
     */
    private $module;

    /**
     * @var string|null
     * @ORM\Column(name="contextKeyName")
     */
    private $contextKeyName;

    /**
     * @var integer|null
     * @ORM\Column(name="contextKeyValue", type="bigint", columnDefinition="INT(20)")
     */
    private $contextKeyValue;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDRecipient", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $recipient;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDGiver", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $giver;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $comment;

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
     * @return Like
     */
    public function setId(?int $id): Like
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
     * @return Like
     */
    public function setSchoolYear(?SchoolYear $schoolYear): Like
    {
        $this->schoolYear = $schoolYear;
        return $this;
    }

    /**
     * @return Module|null
     */
    public function getModule(): ?Module
    {
        return $this->module;
    }

    /**
     * @param Module|null $module
     * @return Like
     */
    public function setModule(?Module $module): Like
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContextKeyName(): ?string
    {
        return $this->contextKeyName;
    }

    /**
     * @param string|null $contextKeyName
     * @return Like
     */
    public function setContextKeyName(?string $contextKeyName): Like
    {
        $this->contextKeyName = $contextKeyName;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getContextKeyValue(): ?int
    {
        return $this->contextKeyValue;
    }

    /**
     * @param int|null $contextKeyValue
     * @return Like
     */
    public function setContextKeyValue(?int $contextKeyValue): Like
    {
        $this->contextKeyValue = $contextKeyValue;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getRecipient(): ?Person
    {
        return $this->recipient;
    }

    /**
     * @param Person|null $recipient
     * @return Like
     */
    public function setRecipient(?Person $recipient): Like
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getGiver(): ?Person
    {
        return $this->giver;
    }

    /**
     * @param Person|null $giver
     * @return Like
     */
    public function setGiver(?Person $giver): Like
    {
        $this->giver = $giver;
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
     * @return Like
     */
    public function setTitle(?string $title): Like
    {
        $this->title = $title;
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
     * @return Like
     */
    public function setComment(?string $comment): Like
    {
        $this->comment = $comment;
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
     * @return Like
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestamp(?\DateTime $timestamp = null): Like
    {
        $this->timestamp = $timestamp ?: new \DateTime('now');
        return $this;
    }
}