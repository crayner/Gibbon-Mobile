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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class Group
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 * @ORM\Table(name="Group")
 * @ORM\HasLifecycleCallbacks()
 */
class Group
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonGroupID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDOwner", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $owner;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=false)
     */
    private $schoolYear;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $name;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampCreated", nullable=true)
     */
    private $timestampCreated;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampUpdated", options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
     */
    private $timestampUpdated;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Entity\GroupPerson", mappedBy="group")
     */
    private $people;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Group
     */
    public function setId(?int $id): Group
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getOwner(): ?Person
    {
        return $this->owner;
    }

    /**
     * @param Person|null $owner
     * @return Group
     */
    public function setOwner(?Person $owner): Group
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return SchoolYear|null
     */
    public function getSchoolYear(): ?SchoolYear
    {
        return $this->schoolYear;
    }

    /**
     * @param SchoolYear|null $schoolYear
     * @return Group
     */
    public function setSchoolYear(?SchoolYear $schoolYear): Group
    {
        $this->schoolYear = $schoolYear;
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
     * @return Group
     */
    public function setName(?string $name): Group
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampCreated(): ?\DateTime
    {
        return $this->timestampCreated;
    }

    /**
     * setTimestampCreated
     * @param \DateTime|null $timestampCreated
     * @return Group
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestampCreated(?\DateTime $timestampCreated = null): Group
    {
        $this->timestampCreated = $timestampCreated ?: new \DateTime('now');
        return $this->setTimestampUpdated($this->getTimestampCreated());
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampUpdated(): ?\DateTime
    {
        return $this->timestampUpdated;
    }

    /**
     * setTimestampUpdated
     * @param \DateTime|null $timestampUpdated
     * @return Group
     * @throws \Exception
     * @ORM\PreUpdate()
     */
    public function setTimestampUpdated(?\DateTime $timestampUpdated = null): Group
    {
        $this->timestampUpdated = $timestampUpdated ?: new \DateTime('now');
        return $this;
    }

    /**
     * getPeople
     * @return Collection
     */
    public function getPeople(): Collection
    {
        if (empty($this->people))
            $this->people = new ArrayCollection();

        if ($this->people instanceof PersistentCollection)
            $this->people->initialize();

        return $this->people;
    }

    /**
     * @param Collection|null $people
     * @return Group
     */
    public function setPeople(?Collection $people): Group
    {
        $this->people = $people;
        return $this;
    }
}