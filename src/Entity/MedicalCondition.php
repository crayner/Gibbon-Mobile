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
 * Class MedicalCondition
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MedicalConditionRepository")
 * @ORM\Table(name="MedicalCondition", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 */
class MedicalCondition
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonMedicalConditionID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=80)
     */
    private $name;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return MedicalCondition
     */
    public function setId(?int $id): MedicalCondition
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
     * @return MedicalCondition
     */
    public function setName(?string $name): MedicalCondition
    {
        $this->name = $name;
        return $this;
    }
}