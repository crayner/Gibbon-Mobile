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
 * Class FinanceBudgetPerson
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FinanceBudgetPersonRepository")
 * @ORM\Table(name="FinanceBudgetPerson")
 */
class FinanceBudgetPerson
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonFinanceBudgetPersonID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var FinanceBudget|null
     * @ORM\ManyToOne(targetEntity="FinanceBudget")
     * @ORM\JoinColumn(name="gibbonFinanceBudgetID", referencedColumnName="gibbonFinanceBudgetID", nullable=false)
     */
    private $financeBudget;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string
     * @ORM\Column(length=6)
     */
    private $access = 'Read';

    /**
     * @var array
     */
    private static $accessList = ['Full', 'Write', 'Read'];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return FinanceBudgetPerson
     */
    public function setId(?int $id): FinanceBudgetPerson
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return FinanceBudget|null
     */
    public function getFinanceBudget(): ?FinanceBudget
    {
        return $this->financeBudget;
    }

    /**
     * @param FinanceBudget|null $financeBudget
     * @return FinanceBudgetPerson
     */
    public function setFinanceBudget(?FinanceBudget $financeBudget): FinanceBudgetPerson
    {
        $this->financeBudget = $financeBudget;
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
     * @return FinanceBudgetPerson
     */
    public function setPerson(?Person $person): FinanceBudgetPerson
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccess(): string
    {
        return $this->access;
    }

    /**
     * @param string $access
     * @return FinanceBudgetPerson
     */
    public function setAccess(string $access): FinanceBudgetPerson
    {
        $this->access = in_array($access, self::getAccessList()) ? $access : 'Read';
        return $this;
    }

    /**
     * @return array
     */
    public static function getAccessList(): array
    {
        return self::$accessList;
    }
}