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
 * Time: 16:45
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class TTColumnRow
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTColumnRowRepository")
 * @ORM\Table(name="TTColumnRow", indexes={@ORM\Index(name="gibbonTTColumnID", columns={"gibbonTTColumnID"})})
 */
class TTColumnRow implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonTTColumnRowID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var TTColumn|null
     * @ORM\ManyToOne(targetEntity="TTColumn", inversedBy="timetableColumnRows")
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
     * @var \DateTime|null
     * @ORM\Column(type="time",name="timeStart")
     */
    private $timeStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time",name="timeEnd")
     */
    private $timeEnd;

    /**
     * @var string
     * @ORM\Column(length=8)
     */
    private $type;

    /**
     * @var array
     */
    private static $typeList = ['Lesson','Pastoral','Sport','Break','Service','Other'];

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="TTDayRowClass", mappedBy="TTColumnRow")
     */
    private $TTDayRowClasses;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TTColumnRow
     */
    public function setId(?int $id): TTColumnRow
    {
        $this->id = $id;
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
     * @return TTColumnRow
     */
    public function setTTColumn(?TTColumn $TTColumn): TTColumnRow
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
     * @return TTColumnRow
     */
    public function setName(?string $name): TTColumnRow
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
     * @return TTColumnRow
     */
    public function setNameShort(?string $nameShort): TTColumnRow
    {
        $this->nameShort = $nameShort;
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
     * @return TTColumnRow
     */
    public function setTimeStart(?\DateTime $timeStart): TTColumnRow
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
     * @return TTColumnRow
     */
    public function setTimeEnd(?\DateTime $timeEnd): TTColumnRow
    {
        $this->timeEnd = $timeEnd;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return TTColumnRow
     */
    public function setType(string $type): TTColumnRow
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : null ;
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
     * getTTDayRowClasses
     * @return Collection|null
     */
    public function getTTDayRowClasses(): ?Collection
    {
        if (empty($this->TTDayRowClasses))
            $this->TTDayRowClasses = new ArrayCollection();

        if ($this->TTDayRowClasses instanceof PersistentCollection)
            $this->TTDayRowClasses->initialize();

        return $this->TTDayRowClasses;
    }

    /**
     * @param Collection|null $TTDayRowClasses
     * @return TTColumnRow
     */
    public function setTTDayRowClasses(?Collection $TTDayRowClasses): TTColumnRow
    {
        $this->TTDayRowClasses = $TTDayRowClasses;
        return $this;
    }
}