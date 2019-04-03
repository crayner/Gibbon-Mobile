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
 * Class Resource
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ResourceRepository")
 * @ORM\Table(name="Resource")
 */
class Resource
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonResourceID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=60)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(name="gibbonYearGroupIDList")
     */
    private $yearGroupList;

    /**
     * @var string|null
     * @ORM\Column(length=4)
     */
    private $type;

    /**
     * @var array
     */
    private static $typeList = ['File', 'HTML', 'Link'];

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $category;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $purpose;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $tags;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

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
     * @return Resource
     */
    public function setId(?int $id): Resource
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
     * @return Resource
     */
    public function setName(?string $name): Resource
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Resource
     */
    public function setDescription(?string $description): Resource
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getYearGroupList(): ?string
    {
        return $this->yearGroupList;
    }

    /**
     * @param string|null $yearGroupList
     * @return Resource
     */
    public function setYearGroupList(?string $yearGroupList): Resource
    {
        $this->yearGroupList = $yearGroupList;
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
     * @return Resource
     */
    public function setType(?string $type): Resource
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : '';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return Resource
     */
    public function setCategory(?string $category): Resource
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPurpose(): ?string
    {
        return $this->purpose;
    }

    /**
     * @param string|null $purpose
     * @return Resource
     */
    public function setPurpose(?string $purpose): Resource
    {
        $this->purpose = $purpose;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * @param string|null $tags
     * @return Resource
     */
    public function setTags(?string $tags): Resource
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return Resource
     */
    public function setContent(?string $content): Resource
    {
        $this->content = $content;
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
     * @return Resource
     */
    public function setPerson(?Person $person): Resource
    {
        $this->person = $person;
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
     * @return Resource
     */
    public function setTimestamp(?\DateTime $timestamp): Resource
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return array
     */
    public static function getTypeList(): array
    {
        return self::$typeList;
    }
}