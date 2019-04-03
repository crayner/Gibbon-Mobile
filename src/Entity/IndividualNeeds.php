<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 20 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 23/11/20
 * Time: 15:27
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class IndividualNeeds
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\IndividualNeedsRepository")
 * @ORM\Table(name="IN", uniqueConstraints={@ORM\UniqueConstraint(name="gibbonPersonID", columns={"gibbonPersonID"})})
 */
class IndividualNeeds implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonINID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $strategies;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $targets;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $notes;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return In
     */
    public function setId(?int $id): IndividualNeeds
    {
        $this->id = $id;
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
     * @return In
     */
    public function setPerson(?Person $person): IndividualNeeds
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStrategies(): ?string
    {
        return $this->strategies;
    }

    /**
     * @param string|null $strategies
     * @return In
     */
    public function setStrategies(?string $strategies): IndividualNeeds
    {
        $this->strategies = $strategies;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTargets(): ?string
    {
        return $this->targets;
    }

    /**
     * @param string|null $targets
     * @return In
     */
    public function setTargets(?string $targets): IndividualNeeds
    {
        $this->targets = $targets;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     * @return In
     */
    public function setNotes(?string $notes): IndividualNeeds
    {
        $this->notes = $notes;
        return $this;
    }
}