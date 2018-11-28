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
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


class Log
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonLogID", columnDefinition="INT(16) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Log
     */
    public function setId(?int $id): Log
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID")
     *
     */
    private $schoolYear;

    /**
     * @return SchoolYear|null
     */
    public function getSchoolYear(): ?SchoolYear
    {
        return $this->schoolYear;
    }

    /**
     * @param SchoolYear|null $schoolYear
     * @return Log
     */
    public function setSchoolYear(?SchoolYear $schoolYear): Log
    {
        $this->schoolYear = $schoolYear;
        return $this;
    }

    /**
     * @var \DateTime|null
     */
    private $timestamp;

    /**
     * @return \DateTime|null
     */
    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime|null $timestamp
     * @return Log
     */
    public function setTimestamp(?\DateTime $timestamp): Log
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Log constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setTimestamp(new \DateTime('now'));
    }

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $title;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Log
     */
    public function setTitle(?string $title): Log
    {
        $this->title = mb_substr($title, 0, 50);
        return $this;
    }

    /**
     * @var array|null
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $serialisedArray;

    /**
     * @return array|null
     */
    public function getSerialisedArray(): ?array
    {
        return $this->serialisedArray;
    }

    /**
     * @param array|null $serialisedArray
     * @return Log
     */
    public function setSerialisedArray(?array $serialisedArray): Log
    {
        $this->serialisedArray = $serialisedArray;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=15)
     */
    private $ip;

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     * @return Log
     */
    public function setIp(?string $ip): Log
    {
        $this->ip = mb_substr($ip, 0, 15);
        return $this;
    }
}