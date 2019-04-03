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
 * Time: 22:05
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UnitClass
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UnitClassRepository")
 * @ORM\Table(name="UnitClass")
 */
class UnitClass implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonUnitClassID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Unit|null
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumn(name="gibbonUnitID", referencedColumnName="gibbonUnitID", nullable=false)
     */
    private $unit;

    /**
     * @var CourseClass|null
     * @ORM\ManyToOne(targetEntity="CourseClass")
     * @ORM\JoinColumn(name="gibbonCourseClassID", referencedColumnName="gibbonCourseClassID", nullable=false)
     */
    private $courseClass;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $running = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UnitClass
     */
    public function setId(?int $id): UnitClass
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Unit|null
     */
    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    /**
     * @param Unit|null $unit
     * @return UnitClass
     */
    public function setUnit(?Unit $unit): UnitClass
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @return CourseClass|null
     */
    public function getCourseClass(): ?CourseClass
    {
        return $this->courseClass;
    }

    /**
     * @param CourseClass|null $courseClass
     * @return UnitClass
     */
    public function setCourseClass(?CourseClass $courseClass): UnitClass
    {
        $this->courseClass = $courseClass;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRunning(): ?string
    {
        return $this->running;
    }

    /**
     * @param string|null $running
     * @return UnitClass
     */
    public function setRunning(?string $running): UnitClass
    {
        $this->running = self::checkBoolean($running, 'N');
        return $this;
    }
}