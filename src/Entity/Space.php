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
 * Class Space
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SpaceRepository")
 * @ORM\Table(name="Space", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 */
class Space
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonSpaceID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=30, unique=true)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $type;

    /**
     * @var integer
     * @ORM\Column(type="integer", columnDefinition="INT(5)")
     */
    private $capacity;

    /**
     * @var boolean
     * @ORM\Column(length=1)
     */
    private $computer;

    /**
     * @var integer
     * @ORM\Column(type="integer", columnDefinition="INT(3)", name="computerStudent", options={"default": "0"})
     */
    private $studentComputers;

    /**
     * @var boolean
     * @ORM\Column(length=1)
     */
    private $projector;

    /**
     * @var boolean
     * @ORM\Column(length=1)
     */
    private $tv;

    /**
     * @var boolean
     * @ORM\Column(length=1)
     */
    private $dvd;

    /**
     * @var boolean
     * @ORM\Column(length=1)
     */
    private $hifi;

    /**
     * @var boolean
     * @ORM\Column(length=1)
     */
    private $speakers;

    /**
     * @var boolean
     * @ORM\Column(length=1)
     */
    private $iwb;

    /**
     * @var string|null
     * @ORM\Column(length=5, name="phoneInternal")
     */
    private $phoneInt;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="phoneExternal")
     */
    private $phoneExt;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Space
     */
    public function setId(?int $id): Space
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
     * @return Space
     */
    public function setName(?string $name): Space
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Space
     */
    public function setType(?string $type): Space
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getCapacity(): int
    {
        return $this->capacity;
    }

    /**
     * @param int $capacity
     * @return Space
     */
    public function setCapacity(int $capacity): Space
    {
        $this->capacity = $capacity;
        return $this;
    }

    /**
     * @return bool
     */
    public function isComputer(): bool
    {
        return $this->computer;
    }

    /**
     * @param bool $computer
     * @return Space
     */
    public function setComputer(bool $computer): Space
    {
        $this->computer = $computer;
        return $this;
    }

    /**
     * @return int
     */
    public function getStudentComputers(): int
    {
        return $this->studentComputers;
    }

    /**
     * @param int $studentComputers
     * @return Space
     */
    public function setStudentComputers(int $studentComputers): Space
    {
        $this->studentComputers = $studentComputers;
        return $this;
    }

    /**
     * @return bool
     */
    public function isProjector(): bool
    {
        return $this->projector;
    }

    /**
     * @param bool $projector
     * @return Space
     */
    public function setProjector(bool $projector): Space
    {
        $this->projector = $projector;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTv(): bool
    {
        return $this->tv;
    }

    /**
     * @param bool $tv
     * @return Space
     */
    public function setTv(bool $tv): Space
    {
        $this->tv = $tv;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDvd(): bool
    {
        return $this->dvd;
    }

    /**
     * @param bool $dvd
     * @return Space
     */
    public function setDvd(bool $dvd): Space
    {
        $this->dvd = $dvd;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHifi(): bool
    {
        return $this->hifi;
    }

    /**
     * @param bool $hifi
     * @return Space
     */
    public function setHifi(bool $hifi): Space
    {
        $this->hifi = $hifi;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSpeakers(): bool
    {
        return $this->speakers;
    }

    /**
     * @param bool $speakers
     * @return Space
     */
    public function setSpeakers(bool $speakers): Space
    {
        $this->speakers = $speakers;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIwb(): bool
    {
        return $this->iwb;
    }

    /**
     * @param bool $iwb
     * @return Space
     */
    public function setIwb(bool $iwb): Space
    {
        $this->iwb = $iwb;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneInt(): ?string
    {
        return $this->phoneInt;
    }

    /**
     * @param string|null $phoneInt
     * @return Space
     */
    public function setPhoneInt(?string $phoneInt): Space
    {
        $this->phoneInt = $phoneInt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneExt(): ?string
    {
        return $this->phoneExt;
    }

    /**
     * @param string|null $phoneExt
     * @return Space
     */
    public function setPhoneExt(?string $phoneExt): Space
    {
        $this->phoneExt = $phoneExt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return Space
     */
    public function setComment(?string $comment): Space
    {
        $this->comment = $comment;
        return $this;
    }
}