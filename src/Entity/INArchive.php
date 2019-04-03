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
 * Class INArchive
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\INArchiveRepository")
 * @ORM\Table(name="INArchive")
 */
class INArchive
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonINArchiveID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
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
     * @var string|null
     * @ORM\Column(type="text", options={"comment": "Serialised array of descriptors."})
     */
    private $descriptors;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="archiveTitle")
     */
    private $archiveTitle;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="archiveTimestamp", nullable=true)
     */
    private $archiveTimestamp;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return INArchive
     */
    public function setId(?int $id): INArchive
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
     * @return INArchive
     */
    public function setPerson(?Person $person): INArchive
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
     * @return INArchive
     */
    public function setStrategies(?string $strategies): INArchive
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
     * @return INArchive
     */
    public function setTargets(?string $targets): INArchive
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
     * @return INArchive
     */
    public function setNotes(?string $notes): INArchive
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescriptors(): ?string
    {
        return $this->descriptors;
    }

    /**
     * @param string|null $descriptors
     * @return INArchive
     */
    public function setDescriptors(?string $descriptors): INArchive
    {
        $this->descriptors = $descriptors;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getArchiveTitle(): ?string
    {
        return $this->archiveTitle;
    }

    /**
     * @param string|null $archiveTitle
     * @return INArchive
     */
    public function setArchiveTitle(?string $archiveTitle): INArchive
    {
        $this->archiveTitle = $archiveTitle;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getArchiveTimestamp(): ?\DateTime
    {
        return $this->archiveTimestamp;
    }

    /**
     * @param \DateTime|null $archiveTimestamp
     * @return INArchive
     */
    public function setArchiveTimestamp(?\DateTime $archiveTimestamp): INArchive
    {
        $this->archiveTimestamp = $archiveTimestamp;
        return $this;
    }
}