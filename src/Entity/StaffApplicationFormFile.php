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
 * Class StaffApplicationFormFile
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StaffApplicationFormFileRepository")
 * @ORM\Table(name="StaffApplicationFormFile")
 */
class StaffApplicationFormFile
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonStaffApplicationFormFileID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var StaffApplicationForm|null
     * @ORM\ManyToOne(targetEntity="StaffApplicationForm")
     * @ORM\JoinColumn(name="gibbonStaffApplicationFormID", referencedColumnName="gibbonStaffApplicationFormID", nullable=true)
     */
    private $staffApplicationForm;

    /**
     * @var string:null
     * @ORM\Column()
     */
    private $name;

    /**
     * @var string:null
     * @ORM\Column()
     */
    private $path;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return StaffApplicationFormFile
     */
    public function setId(?int $id): StaffApplicationFormFile
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return StaffApplicationForm|null
     */
    public function getStaffApplicationForm(): ?StaffApplicationForm
    {
        return $this->staffApplicationForm;
    }

    /**
     * @param StaffApplicationForm|null $staffApplicationForm
     * @return StaffApplicationFormFile
     */
    public function setStaffApplicationForm(?StaffApplicationForm $staffApplicationForm): StaffApplicationFormFile
    {
        $this->staffApplicationForm = $staffApplicationForm;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return StaffApplicationFormFile
     */
    public function setName(string $name): StaffApplicationFormFile
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return StaffApplicationFormFile
     */
    public function setPath(string $path): StaffApplicationFormFile
    {
        $this->path = $path;
        return $this;
    }
}