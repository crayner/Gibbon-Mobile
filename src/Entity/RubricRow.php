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
 * Class RubricRow
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RubricRowRepository")
 * @ORM\Table(name="RubricRow", indexes={@ORM\Index(name="gibbonRubricID", columns={"gibbonRubricID"})})
 * @ORM\HasLifecycleCallbacks()
 */
class RubricRow
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonRubricRowID", columnDefinition="INT(9) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Rubric|null
     * @ORM\ManyToOne(targetEntity="Rubric")
     * @ORM\JoinColumn(name="gibbonRubricID", referencedColumnName="gibbonRubricID", nullable=false)
     */
    private $rubric;

    /**
     * @var string|null
     * @ORM\Column(length=40)
     */
    private $title;

    /**
     * @var integer
     * @ORM\Column(type="smallint",columnDefinition="INT(2)",name="sequenceNumber")
     */
    private $sequenceNumber;

    /**
     * @var Outcome|null
     * @ORM\ManyToOne(targetEntity="Outcome")
     * @ORM\JoinColumn(name="gibbonOutcomeID", referencedColumnName="gibbonOutcomeID")
     */
    private $outcome;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return RubricRow
     */
    public function setId(?int $id): RubricRow
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Rubric|null
     */
    public function getRubric(): ?Rubric
    {
        return $this->rubric;
    }

    /**
     * @param Rubric|null $rubric
     * @return RubricRow
     */
    public function setRubric(?Rubric $rubric): RubricRow
    {
        $this->rubric = $rubric;
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
     * @return RubricRow
     */
    public function setTitle(?string $title): RubricRow
    {
        $this->title = $title;
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
     * @return RubricRow
     */
    public function setSequenceNumber(int $sequenceNumber): RubricRow
    {
        $this->sequenceNumber = $sequenceNumber;
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
     * @return RubricRow
     */
    public function setOutcome(?Outcome $outcome): RubricRow
    {
        $this->outcome = $outcome;
        return $this;
    }
}