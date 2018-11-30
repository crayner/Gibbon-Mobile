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
 * Class AttendanceCode
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AttendanceCodeRepository")
 * @ORM\Table(name="AttendanceCode")
 */
class AttendanceCode
{
    use BooleanList;
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="smallint", name="gibbonAttendanceCodeID", columnDefinition="INT(3) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=4, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(length=12)
     */
    private $type;

    /**
     * @var array
     */
    private static $typeList = ['Core', 'Additional'];

    /**
     * @var string|null
     * @ORM\Column(length=3)
     */
    private $direction;

    /**
     * @var array
     */
    private static $directionList = ['In','Out'];

    /**
     * @var string|null
     * @ORM\Column(length=14)
     */
    private $scope;

    /**
     * @var array
     */
    private static $scopeList = ['Onsite','Onsite - Late','Offsite','Offsite - Left'];

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $active;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $reportable;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $future;

    /**
     * @var string|null
     * @ORM\Column(length=90, name="gibbonRoleIDAll")
     */
    private $roleAll;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="sequenceNumber")
     */
    private $sequenceNumber;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return AttendanceCode
     */
    public function setId(?int $id): AttendanceCode
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return AttendanceCode
     */
    public function setName(?string $name): AttendanceCode
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameShort(): ?string
    {
        return $this->nameShort;
    }

    /**
     * @param string|null $nameShort
     * @return AttendanceCode
     */
    public function setNameShort(?string $nameShort): AttendanceCode
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return AttendanceCode
     */
    public function setType(?string $type): AttendanceCode
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDirection(): ?string
    {
        return $this->direction;
    }

    /**
     * @param string|null $direction
     * @return AttendanceCode
     */
    public function setDirection(?string $direction): AttendanceCode
    {
        $this->direction = in_array($direction, self::getDirectionList()) ? $direction :  '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * @param string|null $scope
     * @return AttendanceCode
     */
    public function setScope(?string $scope): AttendanceCode
    {
        $this->scope = in_array($scope, self::getScopeList()) ? $scope : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * @param string|null $active
     * @return AttendanceCode
     */
    public function setActive(?string $active): AttendanceCode
    {
        $this->active = in_array($active, self::getBooleanList()) ? $active : 'N';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReportable(): ?string
    {
        return $this->reportable;
    }

    /**
     * @param string|null $reportable
     * @return AttendanceCode
     */
    public function setReportable(?string $reportable): AttendanceCode
    {
        $this->reportable = in_array($reportable, self::getBooleanList()) ? $reportable : 'N';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFuture(): ?string
    {
        return $this->future;
    }

    /**
     * @param string|null $future
     * @return AttendanceCode
     */
    public function setFuture(?string $future): AttendanceCode
    {
        $this->future = in_array($future, self::getBooleanList()) ? $future : 'N';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoleAll(): ?string
    {
        return $this->roleAll;
    }

    /**
     * @param string|null $roleAll
     * @return AttendanceCode
     */
    public function setRoleAll(?string $roleAll): AttendanceCode
    {
        $this->roleAll = $roleAll;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int|null $sequenceNumber
     * @return AttendanceCode
     */
    public function setSequenceNumber(?int $sequenceNumber): AttendanceCode
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * @return array
     */
    public static function getTypeList(): array
    {
        return self::$typeList;
    }

    /**
     * @return array
     */
    public static function getDirectionList(): array
    {
        return self::$directionList;
    }

    /**
     * @return array
     */
    public static function getScopeList(): array
    {
        return self::$scopeList;
    }
}