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
 * Time: 17:00
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use App\Util\EntityHelper;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TTDayRowClass
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTDayRowClassRepository")
 * @ORM\Table(name="TTDayRowClass", indexes={@ORM\Index(name="gibbonCourseClassID", columns={"gibbonCourseClassID"}), @ORM\Index(name="gibbonSpaceID", columns={"gibbonSpaceID"}), @ORM\Index(name="gibbonTTColumnRowID", columns={"gibbonTTColumnRowID"})})
 * @ORM\HasLifecycleCallbacks()
 */
class TTDayRowClass implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonTTDayRowClassID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var TTColumnRow|null
     * @ORM\ManyToOne(targetEntity="TTColumnRow", inversedBy="TTDayRowClasses")
     * @ORM\JoinColumn(name="gibbonTTColumnRowID", referencedColumnName="gibbonTTColumnRowID", nullable=false)
     */
    private $TTColumnRow;

    /**
     * @var TTDay|null
     * @ORM\ManyToOne(targetEntity="TTDay", inversedBy="TTDayRowClasses")
     * @ORM\JoinColumn(name="gibbonTTDayID", referencedColumnName="gibbonTTDayID", nullable=false)
     */
    private $TTDay;

    /**
     * @var CourseClass|null
     * @ORM\ManyToOne(targetEntity="CourseClass", inversedBy="TTDayRowClasses")
     * @ORM\JoinColumn(name="gibbonCourseClassID", referencedColumnName="gibbonCourseClassID", nullable=false)
     */
    private $courseClass;

    /**
     * @var Space|null
     * @ORM\ManyToOne(targetEntity="Space")
     * @ORM\JoinColumn(name="gibbonSpaceID", referencedColumnName="gibbonSpaceID")
     */
    private $space;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TTDayRowClass
     */
    public function setId(?int $id): TTDayRowClass
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return TTColumnRow|null
     */
    public function getTTColumnRow(): ?TTColumnRow
    {
        return $this->TTColumnRow;
    }

    /**
     * @param TTColumnRow|null $TTColumnRow
     * @return TTDayRowClass
     */
    public function setTTColumnRow(?TTColumnRow $TTColumnRow): TTDayRowClass
    {
        $this->TTColumnRow = $TTColumnRow;
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
     * @return TTDayRowClass
     */
    public function setTTDay(?TTDay $TTDay): TTDayRowClass
    {
        $this->TTDay = $TTDay;
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
     * @return TTDayRowClass
     */
    public function setCourseClass(?CourseClass $courseClass): TTDayRowClass
    {
        $this->courseClass = $courseClass;
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
     * @return TTDayRowClass
     */
    public function setSpace(?Space $space): TTDayRowClass
    {
        $this->space = $space;
        return $this;
    }

    /**
     * __toArray
     * @param array $ignore
     * @return array
     */
    public function __toArray(array $ignore = []): array
    {
        return EntityHelper::__toArray(TTDayRowClass::class, $this, $ignore);
    }
}