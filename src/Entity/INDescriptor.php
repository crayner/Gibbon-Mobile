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
 * Class INDescriptor
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\INDescriptorRepository")
 * @ORM\Table(name="INDescriptor")
 */
class INDescriptor
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonINDescriptorID", columnDefinition="INT(3) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=5, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", name="sequenceNumber", columnDefinition="INT(3)")
     */
    private $sequenceNumber;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return INDescriptor
     */
    public function setId(?int $id): INDescriptor
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
     * @return INDescriptor
     */
    public function setName(?string $name): INDescriptor
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
     * @return INDescriptor
     */
    public function setNameShort(?string $nameShort): INDescriptor
    {
        $this->nameShort = $nameShort;
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
     * @return INDescriptor
     */
    public function setDescription(?string $description): INDescriptor
    {
        $this->description = $description;
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
     * @return INDescriptor
     */
    public function setSequenceNumber(?int $sequenceNumber): INDescriptor
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }
}