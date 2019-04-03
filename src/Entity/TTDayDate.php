<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 5/12/2018
 * Time: 16:56
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TTDayDate
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTDayDateRepository")
 * @ORM\Table(name="TTDayDate", indexes={@ORM\Index(name="gibbonTTDayID", columns={"gibbonTTDayID"})})
 */
class TTDayDate implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonTTDayDateID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var TTDay|null
     * @ORM\ManyToOne(targetEntity="TTDay", inversedBy="timetableDayDates")
     * @ORM\JoinColumn(name="gibbonTTDayID", referencedColumnName="gibbonTTDayID", nullable=false)
     */
    private $TTDay;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TTDayDate
     */
    public function setId(?int $id): TTDayDate
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return TTDay|null
     */
    public function getTTDay(): ?TTDay
    {
        return $this->TTDay;
    }

    /**
     * @param TTDay|null $TTDay
     * @return TTDayDate
     */
    public function setTTDay(?TTDay $TTDay): TTDayDate
    {
        $this->TTDay = $TTDay;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     * @return TTDayDate
     */
    public function setDate(?\DateTime $date): TTDayDate
    {
        $this->date = $date;
        return $this;
    }
}