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
 * Class FinanceExpenseLog
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceExpenseLogRepository")
 * @ORM\Table(name="FinanceExpenseLog")
 */
class FinanceExpenseLog
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonFinanceExpenseLogID", columnDefinition="INT(16) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var FinanceExpense|null
     * @ORM\ManyToOne(targetEntity="FinanceExpense")
     * @ORM\JoinColumn(name="gibbonFinanceExpenseID", referencedColumnName="gibbonFinanceExpenseID")
     */
    private $financeExpense;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @var string|null
     * @ORM\Column(length=24)
     */
    private $action;

    /**
     * @var array
     */
    private static $actionList = ['Request','Approval - Partial - Budget','Approval - Partial - School','Approval - Final','Approval - Exempt','Rejection','Cancellation','Order','Payment','Reimbursement Request','Reimbursement Completion','Comment'];

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FinanceExpenseLog
     */
    public function setId(?int $id): FinanceExpenseLog
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return FinanceExpense|null
     */
    public function getFinanceExpense(): ?FinanceExpense
    {
        return $this->financeExpense;
    }

    /**
     * @param FinanceExpense|null $financeExpense
     * @return FinanceExpenseLog
     */
    public function setFinanceExpense(?FinanceExpense $financeExpense): FinanceExpenseLog
    {
        $this->financeExpense = $financeExpense;
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
     * @return FinanceExpenseLog
     */
    public function setPerson(?Person $person): FinanceExpenseLog
    {
        $this->person = $person;
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
     * @return FinanceExpenseLog
     */
    public function setTimestamp(?\DateTime $timestamp): FinanceExpenseLog
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @param string|null $action
     * @return FinanceExpenseLog
     */
    public function setAction(?string $action): FinanceExpenseLog
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return FinanceExpenseLog
     */
    public function setComment(?string $comment): FinanceExpenseLog
    {
        $this->comment = $comment;
        return $this;
    }
}