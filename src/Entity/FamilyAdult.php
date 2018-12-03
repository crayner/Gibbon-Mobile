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

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class FamilyAdult
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FamilyAdultRepository")
 * @ORM\Table(name="FamilyAdult", indexes={@ORM\Index(name="gibbonFamilyID", columns={"gibbonFamilyID","contactPriority"}),@ORM\Index(name="gibbonPersonIndex", columns={"gibbonPersonID"})})
 */
class FamilyAdult
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonFamilyAdultID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Family|null
     * @ORM\ManyToOne(targetEntity="Family")
     * @ORM\JoinColumn(name="gibbonFamilyID", referencedColumnName="gibbonFamilyID")
     */
    private $Family;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="childDataAccess")
     */
    private $childDataAccess;

    /**
     * @var string|null
     * @ORM\Column(type="smallint", name="contactPriority")
     */
    private $contactPriority;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="contactCall")
     */
    private $contactCall;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="contactSMS")
     */
    private $contactSMS;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="contactEmail")
     */
    private $contactEmail;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="contactMail")
     */
    private $contactMail;
}