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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RubricCell
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RubricCellRepository")
 * @ORM\Table(name="RubricCell", indexes={@ORM\Index(name="gibbonRubricID", columns={"gibbonRubricID"}), @ORM\Index(name="gibbonRubricColumnID", columns={"gibbonRubricColumnID"}), @ORM\Index(name="gibbonRubricRowID", columns={"gibbonRubricRowID"})})
 */
class RubricCell
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonRubricCellID", columnDefinition="INT(11) UNSIGNED ZEROFILL")
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
     * @var RubricColumn|null
     * @ORM\ManyToOne(targetEntity="RubricColumn")
     * @ORM\JoinColumn(name="gibbonRubricColumnID", referencedColumnName="gibbonRubricColumnID", nullable=false)
     */
    private $rubricColumn;

    /**
     * @var RubricRow|null
     * @ORM\ManyToOne(targetEntity="RubricRow")
     * @ORM\JoinColumn(name="gibbonRubricRowID", referencedColumnName="gibbonRubricRowID", nullable=false)
     */
    private $rubricRow;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $contents;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return RubricCell
     */
    public function setId(?int $id): RubricCell
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
     * @return RubricCell
     */
    public function setRubric(?Rubric $rubric): RubricCell
    {
        $this->rubric = $rubric;
        return $this;
    }

    /**
     * @return RubricColumn|null
     */
    public function getRubricColumn(): ?RubricColumn
    {
        return $this->rubricColumn;
    }

    /**
     * @param RubricColumn|null $rubricColumn
     * @return RubricCell
     */
    public function setRubricColumn(?RubricColumn $rubricColumn): RubricCell
    {
        $this->rubricColumn = $rubricColumn;
        return $this;
    }

    /**
     * @return RubricRow|null
     */
    public function getRubricRow(): ?RubricRow
    {
        return $this->rubricRow;
    }

    /**
     * @param RubricRow|null $rubricRow
     * @return RubricCell
     */
    public function setRubricRow(?RubricRow $rubricRow): RubricCell
    {
        $this->rubricRow = $rubricRow;
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
     * @param string|null $content
     * @return RubricCell
     */
    public function setContents(?string $contents): RubricCell
    {
        $this->contents = $contents;
        return $this;
    }
}