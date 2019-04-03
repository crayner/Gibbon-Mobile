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
 * Time: 22:02
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UnitBlockStar
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UnitBlockStarRepository")
 * @ORM\Table(name="UnitBlockStar")
 */
class UnitBlockStar implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonUnitBlockStarID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var UnitBlock|null
     * @ORM\ManyToOne(targetEntity="UnitBlock")
     * @ORM\JoinColumn(name="gibbonUnitBlockID", referencedColumnName="gibbonUnitBlockID", nullable=false)
     */
    private $unitBlock;

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
     * @return UnitBlockStar
     */
    public function setId(?int $id): UnitBlockStar
    {
        $this->id = $id;
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
     * @return UnitBlockStar
     */
    public function setUnitBlock(?UnitBlock $unitBlock): UnitBlockStar
    {
        $this->unitBlock = $unitBlock;
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
     * @return UnitBlockStar
     */
    public function setPerson(?Person $person): UnitBlockStar
    {
        $this->person = $person;
        return $this;
    }
}