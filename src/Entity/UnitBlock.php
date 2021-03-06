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
 * Time: 21:56
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UnitBlock
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UnitBlockRepository")
 * @ORM\Table(name="UnitBlock")
 */
class UnitBlock implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonUnitBlockID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
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
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(length=3)
     */
    private $length;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $contents;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="teachersNotes")
     */
    private $teachersNotes;

    /**
     * @var integer
     * @ORM\Column(type="smallint", columnDefinition="INT(4)", name="sequenceNumber")
     */
    private $sequenceNumber;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="gibbonOutcomeIDList")
     */
    private $outcomeList;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UnitBlock
     */
    public function setId(?int $id): UnitBlock
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
     * @return UnitBlock
     */
    public function setUnit(?Unit $unit): UnitBlock
    {
        $this->unit = $unit;
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
     * @return UnitBlock
     */
    public function setTitle(?string $title): UnitBlock
    {
        $this->title = $title;
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
     * @return UnitBlock
     */
    public function setType(?string $type): UnitBlock
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLength(): ?string
    {
        return $this->length;
    }

    /**
     * @param string|null $length
     * @return UnitBlock
     */
    public function setLength(?string $length): UnitBlock
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContents(): ?string
    {
        return $this->contents;
    }

    /**
     * @param string|null $contents
     * @return UnitBlock
     */
    public function setContents(?string $contents): UnitBlock
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTeachersNotes(): ?string
    {
        return $this->teachersNotes;
    }

    /**
     * @param string|null $teachersNotes
     * @return UnitBlock
     */
    public function setTeachersNotes(?string $teachersNotes): UnitBlock
    {
        $this->teachersNotes = $teachersNotes;
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
     * @return UnitBlock
     */
    public function setSequenceNumber(int $sequenceNumber): UnitBlock
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOutcomeList(): ?string
    {
        return $this->outcomeList;
    }

    /**
     * @param string|null $outcomeList
     * @return UnitBlock
     */
    public function setOutcomeList(?string $outcomeList): UnitBlock
    {
        $this->outcomeList = $outcomeList;
        return $this;
    }
}