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
 * Class ActivityStudentRepository
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ActivityStudentRepository")
 * @ORM\Table(name="ActivityStudentRepository")
 */
class ActivityStudent
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonActivityStudentID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity")
     * @ORM\JoinColumn(name="gibbonActivityID",referencedColumnName="gibbonActivityID")
     */
    private $activity;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var string
     * @ORM\Column(length=12)
     */
    private $status = 'Pending';

    /**
     * @var array
     */
    private static $statusList = ['Accepted','Pending','Waiting List','Not Accepted'];

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity")
     * @ORM\JoinColumn(name="gibbonActivityIDBackup",referencedColumnName="gibbonActivityID")
     */
    private $activityBackup;

    /**
     * @var string
     * @ORM\Column(length=1, name="invoiceGenerated")
     */
    private $invoiceGenerated = 'N';

    /**
     * @var FinanceInvoice|null
     * @ORM\ManyToOne(targetEntity="FinanceInvoice")
     * @ORM\JoinColumn(name="gibbonFinanceInvoiceID",referencedColumnName="gibbonFinanceInvoiceID")
     */
    private $invoice;

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ActivityStudent
     */
    public function setId(?int $id): ActivityStudent
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return ActivityStudent
     */
    public function setActivity(?Activity $activity): ActivityStudent
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * @param Person|null $person
     * @return ActivityStudent
     */
    public function setPerson(?Person $person): ActivityStudent
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return ActivityStudent
     */
    public function setStatus(string $status): ActivityStudent
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Pending';
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime|null $timestamp
     * @return ActivityStudent
     */
    public function setTimestamp(?\DateTime $timestamp): ActivityStudent
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivityBackup(): ?Activity
    {
        return $this->activityBackup;
    }

    /**
     * @param Activity|null $activityBackup
     * @return ActivityStudent
     */
    public function setActivityBackup(?Activity $activityBackup): ActivityStudent
    {
        $this->activityBackup = $activityBackup;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceGenerated(): string
    {
        return $this->invoiceGenerated;
    }

    /**
     * @param string $invoiceGenerated
     * @return ActivityStudent
     */
    public function setInvoiceGenerated(string $invoiceGenerated): ActivityStudent
    {
        $this->invoiceGenerated = $this->checkBoolean($invoiceGenerated, 'N');
        return $this;
    }

    /**
     * @return FinanceInvoice|null
     */
    public function getInvoice(): ?FinanceInvoice
    {
        return $this->invoice;
    }

    /**
     * @param FinanceInvoice|null $invoice
     * @return ActivityStudent
     */
    public function setInvoice(?FinanceInvoice $invoice): ActivityStudent
    {
        $this->invoice = $invoice;
        return $this;
    }
}