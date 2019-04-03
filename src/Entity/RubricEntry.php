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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RubricEntry
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RubricEntryRepository")
 * @ORM\Table(name="RubricEntry", indexes={@ORM\Index(name="gibbonRubricID", columns={"gibbonRubricID"}), @ORM\Index(name="gibbonPersonID", columns={"gibbonPersonID"}), @ORM\Index(name="gibbonRubricCellID", columns={"gibbonRubricCellID"}), @ORM\Index(name="contextDBTable", columns={"contextDBTable"}), @ORM\Index(name="contextDBTableID", columns={"contextDBTableID"})})
 */
class RubricEntry
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonRubricEntry", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Rubric|null
     * @ORM\ManyToOne(targetEntity="Rubric")
     * @ORM\JoinColumn(name="gibbonRubricID", referencedColumnName="gibbonRubricID", nullable=false)
     */
    private $rubric;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var RubricCell|null
     * @ORM\ManyToOne(targetEntity="RubricCell")
     * @ORM\JoinColumn(name="gibbonRubricCellID", referencedColumnName="gibbonRubricCellID", nullable=false)
     */
    private $rubricCell;

    /**
     * @var string|null
     * @ORM\Column(name="contextDBTable", options={"comment": "Which database table is this entry related to?"})
     */
    private $contextDBTable;

    /**
     * @var integer|null
     * @ORM\Column(name="contextDBTableID", type="bigint", columnDefinition="INT(20) UNSIGNED ZEROFILL")
     */
    private $contextDBTableID;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return RubricEntry
     */
    public function setId(?int $id): RubricEntry
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Rubric|null
     */
    public function getRubric(): ?Rubric
    {
        return $this->rubric;
    }

    /**
     * @param Rubric|null $rubric
     * @return RubricEntry
     */
    public function setRubric(?Rubric $rubric): RubricEntry
    {
        $this->rubric = $rubric;
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
     * @return RubricEntry
     */
    public function setPerson(?Person $person): RubricEntry
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return RubricCell|null
     */
    public function getRubricCell(): ?RubricCell
    {
        return $this->rubricCell;
    }

    /**
     * @param RubricCell|null $rubricCell
     * @return RubricEntry
     */
    public function setRubricCell(?RubricCell $rubricCell): RubricEntry
    {
        $this->rubricCell = $rubricCell;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContextDBTable(): ?string
    {
        return $this->contextDBTable;
    }

    /**
     * @param string|null $contextDBTable
     * @return RubricEntry
     */
    public function setContextDBTable(?string $contextDBTable): RubricEntry
    {
        $this->contextDBTable = $contextDBTable;
        return $this;
    }

    /**
     * @return integer|null
     */
    public function getContextDBTableID(): ?int
    {
        return $this->contextDBTableID;
    }

    /**
     * @param integer|null $contextDBTableID
     * @return RubricEntry
     */
    public function setContextDBTableID(?int $contextDBTableID): RubricEntry
    {
        $this->contextDBTableID = $contextDBTableID;
        return $this;
    }
}