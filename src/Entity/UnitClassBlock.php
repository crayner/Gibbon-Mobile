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
 * Time: 22:08
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UnitClassBlock
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UnitClassBlockRepository")
 * @ORM\Table(name="UnitClassBlock")
 */
class UnitClassBlock implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonUnitClassBlockID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var UnitClass|null
     * @ORM\ManyToOne(targetEntity="UnitClass")
     * @ORM\JoinColumn(name="gibbonUnitClassID", referencedColumnName="gibbonUnitClassID", nullable=false)
     */
    private $unitClass;

    /**
     * @var PlannerEntry|null
     * @ORM\ManyToOne(targetEntity="PlannerEntry")
     * @ORM\JoinColumn(name="gibbonPlannerEntryID", referencedColumnName="gibbonPlannerEntryID", nullable=false)
     */
    private $plannerEntry;

    /**
     * @var UnitBlock|null
     * @ORM\ManyToOne(targetEntity="UnitBlock")
     * @ORM\JoinColumn(name="gibbonUnitBlockID", referencedColumnName="gibbonUnitBlockID", nullable=false)
     */
    private $unitBlock;

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(length=3)
     */
    private $length;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $contents;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="teachersNotes")
     */
    private $teachersNotes;

    /**
     * @var integer
     * @ORM\Column(type="smallint", columnDefinition="INT(4)", name="sequenceNumber")
     */
    private $sequenceNumber;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $complete = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UnitClassBlock
     */
    public function setId(?int $id): UnitClassBlock
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return UnitClass|null
     */
    public function getUnitClass(): ?UnitClass
    {
        return $this->unitClass;
    }

    /**
     * @param UnitClass|null $unitClass
     * @return UnitClassBlock
     */
    public function setUnitClass(?UnitClass $unitClass): UnitClassBlock
    {
        $this->unitClass = $unitClass;
        return $this;
    }

    /**
     * @return PlannerEntry|null
     */
    public function getPlannerEntry(): ?PlannerEntry
    {
        return $this->plannerEntry;
    }

    /**
     * @param PlannerEntry|null $plannerEntry
     * @return UnitClassBlock
     */
    public function setPlannerEntry(?PlannerEntry $plannerEntry): UnitClassBlock
    {
        $this->plannerEntry = $plannerEntry;
        return $this;
    }

    /**
     * @return UnitBlock|null
     */
    public function getUnitBlock(): ?UnitBlock
    {
        return $this->unitBlock;
    }

    /**
     * @param UnitBlock|null $unitBlock
     * @return UnitClassBlock
     */
    public function setUnitBlock(?UnitBlock $unitBlock): UnitClassBlock
    {
        $this->unitBlock = $unitBlock;
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
     * @return UnitClassBlock
     */
    public function setTitle(?string $title): UnitClassBlock
    {
        $this->title = $title;
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
     * @return UnitClassBlock
     */
    public function setType(?string $type): UnitClassBlock
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLength(): ?string
    {
        return $this->length;
    }

    /**
     * @param string|null $length
     * @return UnitClassBlock
     */
    public function setLength(?string $length): UnitClassBlock
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContents(): ?string
    {
        return $this->contents;
    }

    /**
     * @param string|null $contents
     * @return UnitClassBlock
     */
    public function setContents(?string $contents): UnitClassBlock
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTeachersNotes(): ?string
    {
        return $this->teachersNotes;
    }

    /**
     * @param string|null $teachersNotes
     * @return UnitClassBlock
     */
    public function setTeachersNotes(?string $teachersNotes): UnitClassBlock
    {
        $this->teachersNotes = $teachersNotes;
        return $this;
    }

    /**
     * @return int
     */
    public function getSequenceNumber(): int
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int $sequenceNumber
     * @return UnitClassBlock
     */
    public function setSequenceNumber(int $sequenceNumber): UnitClassBlock
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComplete(): ?string
    {
        return $this->complete;
    }

    /**
     * @param string|null $complete
     * @return UnitClassBlock
     */
    public function setComplete(?string $complete): UnitClassBlock
    {
        $this->complete = self::checkBoolean($complete, 'N');
        return $this;
    }
}