<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Log
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 * @ORM\Table(name="Log")
 * @ORM\HasLifecycleCallbacks()
 */
class Log implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonLogID", columnDefinition="INT(16) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Module|null
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumn(name="gibbonModuleID",referencedColumnName="gibbonModuleID")
     */
    private $module;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID")
     */
    private $person;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=false)
     *
     */
    private $schoolYear;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestamp;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $title;

    /**
     * @var array|null
     * @ORM\Column(type="simple_array", nullable=true, name="serialisedArray")
     */
    private $serialisedArray;

    /**
     * @var string|null
     * @ORM\Column(length=15, nullable=true)
     */
    private $ip;

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
     * @return Module|null
     */
    public function getModule(): ?Module
    {
        return $this->module;
    }

    /**
     * @param Module|null $module
     * @return Log
     */
    public function setModule(?Module $module): Log
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPerson(): ?int
    {
        return $this->person;
    }

    /**
     * @param int|null $person
     * @return Log
     */
    public function setPerson(?int $person): Log
    {
        $this->person = $person;
        return $this;
    }

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
        $this->title = $title;
        return $this;
    }

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
        $this->ip = $ip;
        return $this;
    }
}