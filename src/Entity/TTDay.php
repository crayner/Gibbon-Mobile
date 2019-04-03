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
 * Time: 16:52
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class TTDay
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTDayRepository")
 * @ORM\Table(name="TTDay", indexes={@ORM\Index(name="gibbonTTColumnID", columns={"gibbonTTColumnID"})})
 */
class TTDay implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonTTDayID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var TT|null
     * @ORM\ManyToOne(targetEntity="TT", inversedBy="TTDays")
     * @ORM\JoinColumn(name="gibbonTTID", referencedColumnName="gibbonTTID", nullable=false)
     */
    private $TT;

    /**
     * @var TTColumn|null
     * @ORM\ManyToOne(targetEntity="TTColumn")
     * @ORM\JoinColumn(name="gibbonTTColumnID", referencedColumnName="gibbonTTColumnID", nullable=false)
     */
    private $TTColumn;

    /**
     * @var string|null
     * @ORM\Column(length=12)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=4, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="color")
     */
    private $colour;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="fontColor")
     */
    private $fontColour;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="TTDayRowClass", mappedBy="TTDay")
     */
    private $TTDayRowClasses;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="TTDayDate", mappedBy="TTDay")
     */
    private $timetableDayDates;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TTDay
     */
    public function setId(?int $id): TTDay
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return TT|null
     */
    public function getTT(): ?TT
    {
        return $this->TT;
    }

    /**
     * @param TT|null $TT
     * @return TTDay
     */
    public function setTT(?TT $TT): TTDay
    {
        $this->TT = $TT;
        return $this;
    }

    /**
     * @return TTColumn|null
     */
    public function getTTColumn(): ?TTColumn
    {
        return $this->TTColumn;
    }

    /**
     * @param TTColumn|null $TTColumn
     * @return TTDay
     */
    public function setTTColumn(?TTColumn $TTColumn): TTDay
    {
        $this->TTColumn = $TTColumn;
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
     * @return TTDay
     */
    public function setName(?string $name): TTDay
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
     * @return TTDay
     */
    public function setNameShort(?string $nameShort): TTDay
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getColour(): ?string
    {
        return $this->colour;
    }

    /**
     * @param string|null $colour
     * @return TTDay
     */
    public function setColour(?string $colour): TTDay
    {
        $this->colour = $colour;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFontColour(): ?string
    {
        return $this->fontColour;
    }

    /**
     * @param string|null $fontColour
     * @return TTDay
     */
    public function setFontColour(?string $fontColour): TTDay
    {
        $this->fontColour = $fontColour;
        return $this;
    }

    /**
     * getTTDayRowClasses
     * @return Collection
     */
    public function getTTDayRowClasses(): Collection
    {
        if (empty($this->TTDayRowClasses))
            $this->TTDayRowClasses = new ArrayCollection();

        if ($this->TTDayRowClasses instanceof PersistentCollection)
            $this->TTDayRowClasses->initialize();

        return $this->TTDayRowClasses;
    }

    /**
     * @param Collection $TTDayRowClasses
     * @return TTDay
     */
    public function setTTDayRowClasses(Collection $TTDayRowClasses): TTDay
    {
        $this->TTDayRowClasses = $TTDayRowClasses;
        return $this;
    }

    /**
     * getTimetableDayDates
     * @return Collection
     */
    public function getTimetableDayDates(): Collection
    {
        if (empty($this->timetableDayDates))
            $this->timetableDayDates = new ArrayCollection();
        
        if ($this->timetableDayDates instanceof PersistentCollection)
            $this->timetableDayDates->initialize();
        
        return $this->timetableDayDates;
    }

    /**
     * @param Collection $timetableDayDates
     * @return TTDay
     */
    public function setTimetableDayDates(Collection $timetableDayDates): TTDay
    {
        $this->timetableDayDates = $timetableDayDates;
        return $this;
    }
}