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
 * Class FinanceBudgetPerson
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceBudgetPersonRepository")
 * @ORM\Table(name="FinanceBudgetPerson")
 */
class FinanceBudgetPerson
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonFinanceBudgetPersonID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var FinanceBudget|null
     * @ORM\ManyToOne(targetEntity="FinanceBudget")
     * @ORM\JoinColumn(name="gibbonFinanceBudgetID", referencedColumnName="gibbonFinanceBudgetID")
     */
    private $financeBudget;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var string
     * @ORM\Column(length=6)
     */
    private $access = 'Read';

    /**
     * @var array
     */
    private static $accessList = ['Full', 'Write', 'Read'];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FinanceBudgetPerson
     */
    public function setId(?int $id): FinanceBudgetPerson
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return FinanceBudget|null
     */
    public function getFinanceBudget(): ?FinanceBudget
    {
        return $this->financeBudget;
    }

    /**
     * @param FinanceBudget|null $financeBudget
     * @return FinanceBudgetPerson
     */
    public function setFinanceBudget(?FinanceBudget $financeBudget): FinanceBudgetPerson
    {
        $this->financeBudget = $financeBudget;
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
     * @return FinanceBudgetPerson
     */
    public function setPerson(?Person $person): FinanceBudgetPerson
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccess(): string
    {
        return $this->access;
    }

    /**
     * @param string $access
     * @return FinanceBudgetPerson
     */
    public function setAccess(string $access): FinanceBudgetPerson
    {
        $this->access = in_array($access, self::getAccessList()) ? $access : 'Read';
        return $this;
    }

    /**
     * @return array
     */
    public static function getAccessList(): array
    {
        return self::$accessList;
    }
}