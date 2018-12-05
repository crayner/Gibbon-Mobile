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
 * Class Action
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 * @ORM\Table(name="Activity")
 */
class Activity
{
    use BooleanList;
    
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonActivityID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @return array
     */
    public static function getPaymentFirmnessList(): array
    {
        return self::$paymentFirmnessList;
    }

    /**
     * @return array
     */
    public static function getPaymentTypeList(): array
    {
        return self::$paymentTypeList;
    }

    /**
     * @return array
     */
    public static function getProviderList(): array
    {
        return self::$providerList;
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
     * @return Activity
     */
    public function setId(?int $id): Activity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID",referencedColumnName="gibbonSchoolYearID")
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
     * @return Activity
     */
    public function setSchoolYear(?SchoolYear $schoolYear): Activity
    {
        $this->schoolYear = $schoolYear;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $active = 'Y';

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * @param string|null $active
     * @return Activity
     */
    public function setActive(?string $active): Activity
    {
        $this->active = in_array($active, self::getBooleanList()) ? $active : 'Y';
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"comment": "Can a parent/student select this for registration?"})
     */
    private $registration = 'Y';

    /**
     * @return string|null
     */
    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    /**
     * @param string|null $registration
     * @return Activity
     */
    public function setRegistration(?string $registration): Activity
    {
        $this->registration = in_array($registration, self::getBooleanList()) ? $registration : 'Y';
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=40)
     */
    private $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Activity
     */
    public function setName(?string $name): Activity
    {
        $this->name = mb_substr($name, 0, 40);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=8)
     */
    private $provider = 'School';

    /**
     * @var array
     */
    private static $providerList = ['School', 'External'];

    /**
     * @return string|null
     */
    public function getProvider(): ?string
    {
        return $this->provider;
    }

    /**
     * @param string|null $provider
     * @return Activity
     */
    public function setProvider(?string $provider): Activity
    {
        $this->provider = in_array($provider, self::getProviderList()) ? $provider : 'School';
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $type;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Activity
     */
    public function setType(?string $type): Activity
    {
        $this->type = mb_substr($type, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text", name="gibbonSchoolYearTermIDList")
     */
    private $schoolYearTermList;

    /**
     * @return string|null
     */
    public function getSchoolYearTermList(): ?string
    {
        return $this->schoolYearTermList;
    }

    /**
     * @param string|null $schoolYearTermList
     * @return Activity
     */
    public function setSchoolYearTermList(?string $schoolYearTermList): Activity
    {
        $this->schoolYearTermList = $schoolYearTermList;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="listingStart", nullable=true)
     */
    private $listingStart;

    /**
     * @return \DateTime|null
     */
    public function getListingStart(): ?\DateTime
    {
        return $this->listingStart;
    }

    /**
     * @param \DateTime|null $listingStart
     */
    public function setListingStart(?\DateTime $listingStart): Activity
    {
        $this->listingStart = $listingStart;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="listingEnd", nullable=true)
     */
    private $listingEnd;

    /**
     * @return \DateTime|null
     */
    public function getListingEnd(): ?\DateTime
    {
        return $this->listingEnd;
    }

    /**
     * @param \DateTime|null $listingEnd
     */
    public function setListingEnd(?\DateTime $listingEnd): Activity
    {
        $this->listingEnd = $listingEnd;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="programStart", nullable=true, nullable=true)
     */
    private $programStart;

    /**
     * @return \DateTime|null
     */
    public function getProgramStart(): ?\DateTime
    {
        return $this->programStart;
    }

    /**
     * @param \DateTime|null $programStart
     */
    public function setProgramStart(?\DateTime $programStart): Activity
    {
        $this->programStart = $programStart;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="programEnd")
     */
    private $programEnd;

    /**
     * @return \DateTime|null
     */
    public function getProgramEnd(): ?\DateTime
    {
        return $this->programEnd;
    }

    /**
     * @param \DateTime|null $programEnd
     */
    public function setProgramEnd(?\DateTime $programEnd): Activity
    {
        $this->programEnd = $programEnd;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(name="gibbonYearGroupIDList")
     */
    private $yearGroupList;

    /**
     * @return string|null
     */
    public function getYearGroupList(): ?string
    {
        return $this->yearGroupList;
    }

    /**
     * @param string|null $yearGroupList
     * @return Activity
     */
    public function setYearGroupList(?string $yearGroupList): Activity
    {
        $this->yearGroupList = mb_substr($yearGroupList, 0, 255);
        return $this;
    }

    /**
     * @var int
     * @ORM\Column(type="smallint",columnDefinition="INT(3)",name="maxParticipants")
     */
    private $maxParticipants = 0;

    /**
     * @return int
     */
    public function getMaxParticipants(): int
    {
        return $this->maxParticipants;
    }

    /**
     * setMaxParticipants
     * @param int|null $maxParticipants
     * @return Activity
     */
    public function setMaxParticipants(?int $maxParticipants): Activity
    {
        $this->maxParticipants = intval($maxParticipants);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Activity
     */
    public function setDescription(?string $description): Activity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $payment;

    /**
     * @return float|null
     */
    public function getPayment(): ?float
    {
        return $this->payment ? number_format($this->payment, 2) : null;
    }

    /**
     * @param float|null $payment
     * @return Activity
     */
    public function setPayment(?float $payment): Activity
    {
        $this->payment = $payment ? number_format($payment, 2) : null;
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=16, name="paymentType")
     */
    private $paymentType = 'Entire Programme';

    /**
     * @return string
     */
    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return Activity
     */
    public function setPaymentType(string $paymentType): Activity
    {
        $this->paymentType = in_array($paymentType, self::getPaymentTypeList()) ? $paymentType : 'Entire Programme';
        return $this;
    }

    /**
     * @var array
     */
    private static $paymentTypeList = ['Entire Programme','Per Session','Per Week','Per Term'];

    /**
     * @var string
     * @ORM\Column(length=9, name="paymentFirmness")
     */
    private $paymentFirmness = 'Finalised';

    /**
     * @return string
     */
    public function getPaymentFirmness(): string
    {
        return $this->paymentFirmness;
    }

    /**
     * @param string $paymentFirmness
     * @return Activity
     */
    public function setPaymentFirmness(string $paymentFirmness): Activity
    {
        $this->paymentFirmness = in_array($paymentFirmness, self::getPaymentFirmnessList()) ? $paymentFirmness : 'Finalised';
        return $this;
    }

    /**
     * @var array
     */
    private static $paymentFirmnessList = ['Finalised', 'Estimated'];
}