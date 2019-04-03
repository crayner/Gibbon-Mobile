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
 * Class INAssistant
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\INAssistantRepository")
 * @ORM\Table(name="INAssistant")
 */
class INAssistant
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonINAssistantID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDStudent", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $student;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDAssistant", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $assistant;

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
     * @return INAssistant
     */
    public function setId(?int $id): INAssistant
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getStudent(): ?Person
    {
        return $this->student;
    }

    /**
     * @param Person|null $student
     * @return INAssistant
     */
    public function setStudent(?Person $student): INAssistant
    {
        $this->student = $student;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getAssistant(): ?Person
    {
        return $this->assistant;
    }

    /**
     * @param Person|null $assistant
     * @return INAssistant
     */
    public function setAssistant(?Person $assistant): INAssistant
    {
        $this->assistant = $assistant;
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
     * @return INAssistant
     */
    public function setComment(?string $comment): INAssistant
    {
        $this->comment = $comment;
        return $this;
    }
}