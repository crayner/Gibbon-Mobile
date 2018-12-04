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
 * Class MessengerReceipt
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MessengerReceiptRepository")
 * @ORM\Table(name="MessengerReceipt")
 */
class MessengerReceipt
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonMessengerReceiptID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Messenger|null
     * @ORM\ManyToOne(targetEntity="Messenger")
     * @ORM\JoinColumn(name="gibbonMessengerID", referencedColumnName="gibbonMessengerID")
     */
    private $messenger;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=true)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(name="targetType", length=16)
     */
    private $targetType = '';

    /**
     * @var array
     */
    private static $targetTypeList = ['','Class','Course','Roll Group','Year Group','Activity','Role','Applicants','Individuals','Houses','Role Category','Transport','Attendance','Group'];

    /**
     * @var string|null
     * @ORM\Column(name="targetID", length=30)
     */
    private $targetID;

    /**
     * @var string|null
     * @ORM\Column(name="contactType", length=5, nullable=true)
     */
    private $contactType;

    /**
     * @var array
     */
    private static $contactTypeList = ["Email",'SMS'];

    /**
     * @var string|null
     * @ORM\Column(name="contactDetail", nullable=true)
     */
    private $contactDetail;

    /**
     * @var string|null
     * @ORM\Column(length=40, nullable=true)
     */
    private $key;

    /**
     * @var string|null
     * @ORM\Column(length=1, nullable=true)
     */
    private $confirmed;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="confirmedTimestamp", nullable=true)
     */
    private $confirmedTimestamp;
}