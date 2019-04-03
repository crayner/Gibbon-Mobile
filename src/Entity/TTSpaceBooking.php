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
 * Time: 17:18
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TTSpaceBooking
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTSpaceBookingRepository")
 * @ORM\Table(name="TTSpaceBooking")
 */
class TTSpaceBooking  implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonTTSpaceBookingID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="foreignKey", options={"default": "gibbonSpaceID"})
     */
    private $foreignKey = 'gibbonSpaceID';

    /**
     * @var array
     */
    private static $foreignKeyList = ['gibbonSpaceID', 'gibbonLibraryItemID'];

    /**
     * @var integer|null
     * @ORM\Column(type="integer", name="foreignKeyID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     */
    private $foreignKeyID;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="timeStart")
     */
    private $timeStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", name="timeEnd")
     */
    private $timeEnd;

    /**
     * @var Space|null
     */
    private $space;

    /**
     * @var LibraryItem|null
     */
    private $libraryItem;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TTSpaceBooking
     */
    public function setId(?int $id): TTSpaceBooking
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getForeignKey(): ?string
    {
        return $this->foreignKey;
    }

    /**
     * @param string|null $foreignKey
     * @return TTSpaceBooking
     */
    public function setForeignKey(?string $foreignKey): TTSpaceBooking
    {
        $this->foreignKey = in_array($foreignKey, self::getForeignKeyList()) ? $foreignKey : 'gibbonSpaceID';
        return $this;
    }

    /**
     * @return int|null
     */
    public function getForeignKeyID(): ?int
    {
        return $this->foreignKeyID;
    }

    /**
     * @param int|null $foreignKeyID
     * @return TTSpaceBooking
     */
    public function setForeignKeyID(?int $foreignKeyID): TTSpaceBooking
    {
        $this->foreignKeyID = $foreignKeyID;
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
     * @return TTSpaceBooking
     */
    public function setPerson(?Person $person): TTSpaceBooking
    {
        $this->person = $person;
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
     * @return TTSpaceBooking
     */
    public function setDate(?\DateTime $date): TTSpaceBooking
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimeStart(): ?\DateTime
    {
        return $this->timeStart;
    }

    /**
     * @param \DateTime|null $timeStart
     * @return TTSpaceBooking
     */
    public function setTimeStart(?\DateTime $timeStart): TTSpaceBooking
    {
        $this->timeStart = $timeStart;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimeEnd(): ?\DateTime
    {
        return $this->timeEnd;
    }

    /**
     * @param \DateTime|null $timeEnd
     * @return TTSpaceBooking
     */
    public function setTimeEnd(?\DateTime $timeEnd): TTSpaceBooking
    {
        $this->timeEnd = $timeEnd;
        return $this;
    }

    /**
     * @return array
     */
    public static function getForeignKeyList(): array
    {
        return self::$foreignKeyList;
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
     * @return TTSpaceBooking
     */
    public function setSpace(?Space $space): TTSpaceBooking
    {
        $this->space = $space;
        return $this;
    }

    /**
     * @return LibraryItem|null
     */
    public function getLibraryItem(): ?LibraryItem
    {
        return $this->libraryItem;
    }

    /**
     * @param LibraryItem|null $libraryItem
     * @return TTSpaceBooking
     */
    public function setLibraryItem(?LibraryItem $libraryItem): TTSpaceBooking
    {
        $this->libraryItem = $libraryItem;
        return $this;
    }

    /**
     * getName
     * @return string|null
     */
    public function getName(): ?string
    {
        if ($this->getForeignKey() === 'gibbonSpaceID' && $this->getSpace() instanceof Space)
            return $this->getSpace()->getName();
        if ($this->getLibraryItem() instanceof LibraryItem)
            return $this->getLibraryItem()->getName();
        return null;

    }
}