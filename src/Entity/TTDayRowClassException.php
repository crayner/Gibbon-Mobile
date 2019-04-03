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
 * Time: 17:06
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TTDayRowClassException
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTDayRowClassExceptionRepository")
 * @ORM\Table(name="TTDayRowClassException")
 */
class TTDayRowClassException implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonTTDayRowClassExceptionID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var TTDayRowClass|null
     * @ORM\ManyToOne(targetEntity="TTDayRowClass")
     * @ORM\JoinColumn(name="gibbonTTDayRowClassID", referencedColumnName="gibbonTTDayRowClassID", nullable=false)
     */
    private $TTDayRowClass;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
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
     * @return TTDayRowClassException
     */
    public function setId(?int $id): TTDayRowClassException
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return TTDayRowClass|null
     */
    public function getTTDayRowClass(): ?TTDayRowClass
    {
        return $this->TTDayRowClass;
    }

    /**
     * @param TTDayRowClass|null $TTDayRowClass
     * @return TTDayRowClassException
     */
    public function setTTDayRowClass(?TTDayRowClass $TTDayRowClass): TTDayRowClassException
    {
        $this->TTDayRowClass = $TTDayRowClass;
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
     * @return TTDayRowClassException
     */
    public function setPerson(?Person $person): TTDayRowClassException
    {
        $this->person = $person;
        return $this;
    }
}