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
 * Time: 16:35
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class TT
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTRepository")
 * @ORM\Table(name="TT")
 */
class TT implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonTTID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=false)
     */
    private $schoolYear;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=12, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(length=24, name="nameShortDisplay", options={"default": "Day Of The Week"})
     */
    private $nameShortDisplay;

    /**
     * @var array
     */
    private static $nameShortDisplayList = ['Day Of The Week','Dashboard Day Short Name',''];

    /**
     * @var string|null
     * @ORM\Column(name="gibbonYearGroupIDList")
     */
    private $yearGroupList;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $active;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="TTDay", mappedBy="TT")
     */
    private $TTDays;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TT
     */
    public function setId(?int $id): TT
    {
        $this->id = $id;
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
     * @return TT
     */
    public function setSchoolYear(?SchoolYear $schoolYear): TT
    {
        $this->schoolYear = $schoolYear;
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
     * @return TT
     */
    public function setName(?string $name): TT
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
     * @return TT
     */
    public function setNameShort(?string $nameShort): TT
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameShortDisplay(): ?string
    {
        return $this->nameShortDisplay;
    }

    /**
     * @param string|null $nameShortDisplay
     * @return TT
     */
    public function setNameShortDisplay(?string $nameShortDisplay): TT
    {
        $this->nameShortDisplay = in_array($nameShortDisplay, self::getNameShortDisplayList()) ? $nameShortDisplay : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getYearGroupList(): ?string
    {
        return $this->yearGroupList;
    }

    /**
     * @param string|null $yearGroupList
     * @return TT
     */
    public function setYearGroupList(?string $yearGroupList): TT
    {
        $this->yearGroupList = $yearGroupList;
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
     * @return TT
     */
    public function setActive(?string $active): TT
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return array
     */
    public static function getNameShortDisplayList(): array
    {
        return self::$nameShortDisplayList;
    }

    /**
     * getTTDays
     * @return Collection
     */
    public function getTTDays(): Collection
    {
        if (empty($this->tTDays))
            $this->tTDays = new ArrayCollection();

        if ($this->tTDays instanceof PersistentCollection)
            $this->tTDays->initialize();

        return $this->tTDays;
    }

    /**
     * @param Collection $tTDays
     * @return TT
     */
    public function setTTDays(Collection $tTDays): TT
    {
        $this->tTDays = $tTDays;
        return $this;
    }
}