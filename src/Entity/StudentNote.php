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
 * Time: 16:22
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class StudentNote
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StudentNoteRepository")
 * @ORM\Table(name="StudentNote")
 */
class StudentNote
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonStudentNoteID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var StudentNoteCategory|null
     * @ORM\ManyToOne(targetEntity="StudentNoteCategory")
     * @ORM\JoinColumn(name="gibbonStudentNoteCategoryID",referencedColumnName="gibbonStudentNoteCategoryID")
     */
    private $studentNoteCategory;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $note;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $creator;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $timestamp;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return StudentNote
     */
    public function setId(?int $id): StudentNote
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
     * @return StudentNote
     */
    public function setPerson(?Person $person): StudentNote
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return StudentNoteCategory|null
     */
    public function getStudentNoteCategory(): ?StudentNoteCategory
    {
        return $this->studentNoteCategory;
    }

    /**
     * @param StudentNoteCategory|null $studentNoteCategory
     * @return StudentNote
     */
    public function setStudentNoteCategory(?StudentNoteCategory $studentNoteCategory): StudentNote
    {
        $this->studentNoteCategory = $studentNoteCategory;
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
     * @return StudentNote
     */
    public function setTitle(?string $title): StudentNote
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     * @return StudentNote
     */
    public function setNote(?string $note): StudentNote
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getCreator(): ?Person
    {
        return $this->creator;
    }

    /**
     * @param Person|null $creator
     * @return StudentNote
     */
    public function setCreator(?Person $creator): StudentNote
    {
        $this->creator = $creator;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime|null $timestamp
     * @return StudentNote
     */
    public function setTimestamp(?\DateTime $timestamp): StudentNote
    {
        $this->timestamp = $timestamp;
        return $this;
    }
}