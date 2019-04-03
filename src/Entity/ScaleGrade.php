<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Entity;

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ScaleGrade
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ScaleGradeRepository")
 * @ORM\Table(name="ScaleGrade")
 */
class ScaleGrade
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonScaleGradeID", columnDefinition="INT(7) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleID", referencedColumnName="gibbonScaleID", nullable=false)
     */
    private $scale;

    /**
     * @var string|null
     * @ORM\Column(length=10)
     */
    private $value;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $descriptor;

    /**
     * @var integer|null
     * @ORM\Column(type="integer", name="sequenceNumber", columnDefinition="INT(5)")
     */
    private $sequenceNumber;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="isDefault", options={"default": "N"})
     */
    private $isDefault = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ScaleGrade
     */
    public function setId(?int $id): ScaleGrade
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Scale|null
     */
    public function getScale(): ?Scale
    {
        return $this->scale;
    }

    /**
     * @param Scale|null $scale
     * @return ScaleGrade
     */
    public function setScale(?Scale $scale): ScaleGrade
    {
        $this->scale = $scale;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return ScaleGrade
     */
    public function setValue(?string $value): ScaleGrade
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescriptor(): ?string
    {
        return $this->descriptor;
    }

    /**
     * @param string|null $descriptor
     * @return ScaleGrade
     */
    public function setDescriptor(?string $descriptor): ScaleGrade
    {
        $this->descriptor = $descriptor;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int|null $sequenceNumber
     * @return ScaleGrade
     */
    public function setSequenceNumber(?int $sequenceNumber): ScaleGrade
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getisDefault(): ?string
    {
        return $this->isDefault;
    }

    /**
     * @param string|null $isDefault
     * @return ScaleGrade
     */
    public function setIsDefault(?string $isDefault): ScaleGrade
    {
        $this->isDefault = self::checkBoolean($isDefault, 'N');
        return $this;
    }
}