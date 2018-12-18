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
 * Time: 16:56
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TTDayDate
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTDayDateRepository")
 * @ORM\Table(name="TTDayDate", indexes={@ORM\Index(name="gibbonTTDayID", columns={"gibbonTTDayID"})})
 */
class TTDayDate implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonTTDayDateID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var TTDay|null
     * @ORM\ManyToOne(targetEntity="TTDay")
     * @ORM\JoinColumn(name="gibbonTTDayID", referencedColumnName="gibbonTTDayID", nullable=false)
     */
    private $TTDay;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TTDayDate
     */
    public function setId(?int $id): TTDayDate
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return TTDay|null
     */
    public function getTTDay(): ?TTDay
    {
        return $this->TTDay;
    }

    /**
     * @param TTDay|null $TTDay
     * @return TTDayDate
     */
    public function setTTDay(?TTDay $TTDay): TTDayDate
    {
        $this->TTDay = $TTDay;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     * @return TTDayDate
     */
    public function setDate(?\DateTime $date): TTDayDate
    {
        $this->date = $date;
        return $this;
    }
}