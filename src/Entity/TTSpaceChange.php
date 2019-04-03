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
 * Time: 17:26
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TTSpaceChange
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTSpaceChangeRepository")
 * @ORM\Table(name="TTSpaceChange", indexes={@ORM\Index(name="gibbonTTDayRowClassID", columns={"gibbonTTDayRowClassID"}), @ORM\Index(name="date", columns={"date"})})
 */
class TTSpaceChange  implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonTTSpaceChangeID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var TTDayRowClass|null
     * @ORM\ManyToOne(targetEntity="TTDayRowClass")
     * @ORM\JoinColumn(name="gibbonTTDayRowClassID", referencedColumnName="gibbonTTDayRowClassID", nullable=false)
     */
    private $TTDayRowClass;

    /**
     * @var Space|null
     * @ORM\ManyToOne(targetEntity="Space")
     * @ORM\JoinColumn(name="gibbonSpaceID",referencedColumnName="gibbonSpaceID")
     */
    private $space;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TTSpaceChange
     */
    public function setId(?int $id): TTSpaceChange
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return TTDayRowClass|null
     */
    public function getTTDayRowClass(): ?TTDayRowClass
    {
        return $this->TTDayRowClass;
    }

    /**
     * @param TTDayRowClass|null $TTDayRowClass
     * @return TTSpaceChange
     */
    public function setTTDayRowClass(?TTDayRowClass $TTDayRowClass): TTSpaceChange
    {
        $this->TTDayRowClass = $TTDayRowClass;
        return $this;
    }

    /**
     * @return Space|null
     */
    public function getSpace(): ?Space
    {
        return $this->space;
    }

    /**
     * @param Space|null $space
     * @return TTSpaceChange
     */
    public function setSpace(?Space $space): TTSpaceChange
    {
        $this->space = $space;
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
     * @return TTSpaceChange
     */
    public function setDate(?\DateTime $date): TTSpaceChange
    {
        $this->date = $date;
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
     * @return TTSpaceChange
     */
    public function setPerson(?Person $person): TTSpaceChange
    {
        $this->person = $person;
        return $this;
    }
}