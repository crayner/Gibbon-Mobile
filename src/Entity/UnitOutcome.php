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
 * Date: 5/12/2018
 * Time: 22:14
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UnitOutcome
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UnitOutcomeRepository")
 * @ORM\Table(name="UnitOutcome")
 */
class UnitOutcome
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonUnitOutcomeID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Unit|null
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumn(name="gibbonUnitID", referencedColumnName="gibbonUnitID", nullable=false)
     */
    private $unit;

    /**
     * @var Outcome|null
     * @ORM\ManyToOne(targetEntity="Outcome")
     * @ORM\JoinColumn(name="gibbonOutcomeID", referencedColumnName="gibbonOutcomeID", nullable=false)
     */
    private $outcome;

    /**
     * @var integer
     * @ORM\Column(type="smallint",columnDefinition="INT(4)",name="sequenceNumber")
     */
    private $sequenceNumber;

    /**
     * @var integer
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
     * @return UnitOutcome
     */
    public function setId(?int $id): UnitOutcome
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Unit|null
     */
    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    /**
     * @param Unit|null $unit
     * @return UnitOutcome
     */
    public function setUnit(?Unit $unit): UnitOutcome
    {
        $this->unit = $unit;
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
     * @return UnitOutcome
     */
    public function setOutcome(?Outcome $outcome): UnitOutcome
    {
        $this->outcome = $outcome;
        return $this;
    }

    /**
     * @return int
     */
    public function getSequenceNumber(): int
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int $sequenceNumber
     * @return UnitOutcome
     */
    public function setSequenceNumber(int $sequenceNumber): UnitOutcome
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getContent(): int
    {
        return $this->content;
    }

    /**
     * @param int $content
     * @return UnitOutcome
     */
    public function setContent(int $content): UnitOutcome
    {
        $this->content = $content;
        return $this;
    }
}