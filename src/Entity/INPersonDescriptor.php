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
 * Class INPersonDescriptor
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\INPersonDescriptorRepository")
 * @ORM\Table(name="INPersonDescriptor")
 */
class INPersonDescriptor
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonINPersonDescriptorID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var INDescriptor|null
     * @ORM\ManyToOne(targetEntity="INDescriptor")
     * @ORM\JoinColumn(name="gibbonINDescriptorID", referencedColumnName="gibbonINDescriptorID")
     */
    private $inDescriptor;

    /**
     * @var AlertLevel|null
     * @ORM\ManyToOne(targetEntity="AlertLevel")
     * @ORM\JoinColumn(name="gibbonAlertLevelID", referencedColumnName="gibbonAlertLevelID")
     */
    private $alertLevel;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return INPersonDescriptor
     */
    public function setId(?int $id): INPersonDescriptor
    {
        $this->id = $id;
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
     * @return INPersonDescriptor
     */
    public function setPerson(?Person $person): INPersonDescriptor
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return INDescriptor|null
     */
    public function getInDescriptor(): ?INDescriptor
    {
        return $this->inDescriptor;
    }

    /**
     * @param INDescriptor|null $inDescriptor
     * @return INPersonDescriptor
     */
    public function setInDescriptor(?INDescriptor $inDescriptor): INPersonDescriptor
    {
        $this->inDescriptor = $inDescriptor;
        return $this;
    }

    /**
     * @return AlertLevel|null
     */
    public function getAlertLevel(): ?AlertLevel
    {
        return $this->alertLevel;
    }

    /**
     * @param AlertLevel|null $alertLevel
     * @return INPersonDescriptor
     */
    public function setAlertLevel(?AlertLevel $alertLevel): INPersonDescriptor
    {
        $this->alertLevel = $alertLevel;
        return $this;
    }
}