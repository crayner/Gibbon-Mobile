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
 * Time: 16:52
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TTDay
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTDayRepository")
 * @ORM\Table(name="TTDay", indexes={@ORM\Index(name="gibbonTTColumnID", columns={"gibbonTTColumnID"})})
 */
class TTDay
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonTTDayID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var TT|null
     * @ORM\ManyToOne(targetEntity="TT")
     * @ORM\JoinColumn(name="gibbonTTID", referencedColumnName="gibbonTTID", nullable=false)
     */
    private $TT;

    /**
     * @var TTColumn|null
     * @ORM\ManyToOne(targetEntity="TTColumn")
     * @ORM\JoinColumn(name="gibbonTTColumnID", referencedColumnName="gibbonTTColumnID", nullable=false)
     */
    private $TTColumn;

    /**
     * @var string|null
     * @ORM\Column(length=12)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=4, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="color")
     */
    private $colour;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="fontColor")
     */
    private $fontColour;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TTDay
     */
    public function setId(?int $id): TTDay
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return TT|null
     */
    public function getTT(): ?TT
    {
        return $this->TT;
    }

    /**
     * @param TT|null $TT
     * @return TTDay
     */
    public function setTT(?TT $TT): TTDay
    {
        $this->TT = $TT;
        return $this;
    }

    /**
     * @return TTColumn|null
     */
    public function getTTColumn(): ?TTColumn
    {
        return $this->TTColumn;
    }

    /**
     * @param TTColumn|null $TTColumn
     * @return TTDay
     */
    public function setTTColumn(?TTColumn $TTColumn): TTDay
    {
        $this->TTColumn = $TTColumn;
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
     * @return TTDay
     */
    public function setName(?string $name): TTDay
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameShort(): ?string
    {
        return $this->nameShort;
    }

    /**
     * @param string|null $nameShort
     * @return TTDay
     */
    public function setNameShort(?string $nameShort): TTDay
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getColour(): ?string
    {
        return $this->colour;
    }

    /**
     * @param string|null $colour
     * @return TTDay
     */
    public function setColour(?string $colour): TTDay
    {
        $this->colour = $colour;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFontColour(): ?string
    {
        return $this->fontColour;
    }

    /**
     * @param string|null $fontColour
     * @return TTDay
     */
    public function setFontColour(?string $fontColour): TTDay
    {
        $this->fontColour = $fontColour;
        return $this;
    }
}