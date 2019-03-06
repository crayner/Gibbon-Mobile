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
 * Class FinanceBudgetCycle
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceBudgetCycleRepository")
 * @ORM\Table(name="FinanceBudgetCycle", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 */
class FinanceBudgetCycle
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonFinanceBudgetCycleID", columnDefinition="INT(6) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=7)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=8, options={"default": "Upcoming"})
     */
    private $status = 'Upcoming';

    /**
     * @var array
     */
    private static $statusList = ['Past', 'Current', 'Upcoming'];

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="dateStart")
     */
    private $dateStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="dateEnd")
     */
    private $dateEnd;

    /**
     * @var integer|null
     * @ORM\Column(type="integer", name="sequenceNumber", columnDefinition="INT(6)")
     */
    private $sequenceNumber;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $personCreator;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampCreator", nullable=true)
     */
    private $timestampCreator;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDUpdate", referencedColumnName="gibbonPersonID")
     */
    private $personUpdater;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampUpdate", nullable=true)
     */
    private $timestampUpdate;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FinanceBudgetCycle
     */
    public function setId(?int $id): FinanceBudgetCycle
    {
        $this->id = $id;
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
     * @return FinanceBudgetCycle
     */
    public function setName(?string $name): FinanceBudgetCycle
    {
        $this->name = $name;
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
     * @return FinanceBudgetCycle
     */
    public function setStatus(?string $status): FinanceBudgetCycle
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime|null $dateStart
     * @return FinanceBudgetCycle
     */
    public function setDateStart(?\DateTime $dateStart): FinanceBudgetCycle
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime|null $dateEnd
     * @return FinanceBudgetCycle
     */
    public function setDateEnd(?\DateTime $dateEnd): FinanceBudgetCycle
    {
        $this->dateEnd = $dateEnd;
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
     * @return FinanceBudgetCycle
     */
    public function setSequenceNumber(?int $sequenceNumber): FinanceBudgetCycle
    {
        $this->sequenceNumber = $sequenceNumber;
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
     * @return FinanceBudgetCycle
     */
    public function setPersonCreator(?Person $personCreator): FinanceBudgetCycle
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
     * @return FinanceBudgetCycle
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestampCreator(?\DateTime $timestampCreator = null): FinanceBudgetCycle
    {
        $this->timestampCreator = $timestampCreator ?: new \DateTime('now');
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPersonUpdater(): ?Person
    {
        return $this->personUpdater;
    }

    /**
     * @param Person|null $personUpdater
     * @return FinanceBudgetCycle
     */
    public function setPersonUpdater(?Person $personUpdater): FinanceBudgetCycle
    {
        $this->personUpdater = $personUpdater;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampUpdate(): ?\DateTime
    {
        return $this->timestampUpdate;
    }

    /**
     * setTimestampUpdate
     * @param \DateTime|null $timestampUpdate
     * @return FinanceBudgetCycle
     * @throws \Exception
     * @ORM\PreUpdate()
     */
    public function setTimestampUpdate(?\DateTime $timestampUpdate = null): FinanceBudgetCycle
    {
        $this->timestampUpdate = $timestampUpdate ?: new \DateTime('now');
        return $this;
    }
}