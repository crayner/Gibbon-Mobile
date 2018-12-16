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

use App\Manager\EntityInterface;
use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DaysOfWeek
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\DaysOfWeekRepository")
 * @ORM\Table(name="DaysOfWeek", uniqueConstraints={@ORM\UniqueConstraint(name="name",columns={"name", "nameShort"}),@ORM\UniqueConstraint(name="nameShort",columns={"nameShort"}), @ORM\UniqueConstraint(name="sequenceNumber",columns={"sequenceNumber"}) })
 */
class DaysOfWeek implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonDaysOfWeekID", columnDefinition="INT(2) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(length=10)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(length=4, name="nameShort")
     */
    private $nameShort;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="sequenceNumber", columnDefinition="INT(2)")
     */
    private $sequenceNumber;

    /**
     * @var string
     * @ORM\Column(length=1, name="schoolDay", options={"default": "Y"})
     */
    private $schoolDay = 'Y';

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="schoolOpen", nullable=true)
     */
    private $schoolOpen;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="schoolStart", nullable=true)
     */
    private $schoolStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="schoolEnd", nullable=true)
     */
    private $schoolEnd;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="schoolClose", nullable=true)
     */
    private $schoolClose;
}