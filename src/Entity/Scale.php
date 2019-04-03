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
 * Class Scale
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ScaleRepository")
 * @ORM\Table(name="Scale")
 */
class Scale
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="smallint", name="gibbonScaleID", columnDefinition="INT(5) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=40)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=5, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $usage;

    /**
     * @var string|null
     * @ORM\Column(length=5, name="lowestAcceptable", options={"comment": "This is the sequence number of the lowest grade a student can get without being unsatisfactory"}, nullable=true)
     */
    private $lowestAcceptable;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $active = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $numeric = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Scale
     */
    public function setId(?int $id): Scale
    {
        $this->id = $id;
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
     * @return Scale
     */
    public function setName(?string $name): Scale
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
     * @return Scale
     */
    public function setNameShort(?string $nameShort): Scale
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsage(): ?string
    {
        return $this->usage;
    }

    /**
     * @param string|null $usage
     * @return Scale
     */
    public function setUsage(?string $usage): Scale
    {
        $this->usage = $usage;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLowestAcceptable(): ?string
    {
        return $this->lowestAcceptable;
    }

    /**
     * @param string|null $lowestAcceptablee
     * @return Scale
     */
    public function setLowestAcceptable(?string $lowestAcceptable): Scale
    {
        $this->lowestAcceptable = $lowestAcceptable;
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
     * @return Scale
     */
    public function setActive(?string $active): Scale
    {
        $this->active = self::checkBoolean($active);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumeric(): ?string
    {
        return $this->numeric;
    }

    /**
     * @param string|null $numeric
     * @return Scale
     */
    public function setNumeric(?string $numeric): Scale
    {
        $this->numeric = self::checkBoolean($numeric, 'N');
        return $this;
    }
}