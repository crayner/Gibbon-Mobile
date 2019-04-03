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

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PlannerEntryGuest
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PlannerEntryGuestRepository")
 * @ORM\Table(name="PlannerEntryGuest")
 */
class PlannerEntryGuest implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="gibbonPlannerEntryGuestID", columnDefinition="INT(16) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var PlannerEntry|null
     * @ORM\ManyToOne(targetEntity="PlannerEntry", inversedBy="plannerEntryGuests")
     * @ORM\JoinColumn(name="gibbonPlannerEntryID", referencedColumnName="gibbonPlannerEntryID", nullable=false)
     */
    private $plannerEntry;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=16)
     */
    private $role;

    /**
     * @var array 
     */
    private static $roleList = ['Guest Student','Guest Teacher','Guest Assistant','Guest Technician','Guest Parent','Other Guest'];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PlannerEntryGuest
     */
    public function setId(?int $id): PlannerEntryGuest
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return PlannerEntry|null
     */
    public function getPlannerEntry(): ?PlannerEntry
    {
        return $this->plannerEntry;
    }

    /**
     * @param PlannerEntry|null $plannerEntry
     * @return PlannerEntryGuest
     */
    public function setPlannerEntry(?PlannerEntry $plannerEntry): PlannerEntryGuest
    {
        $this->plannerEntry = $plannerEntry;
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
     * @return PlannerEntryGuest
     */
    public function setPerson(?Person $person): PlannerEntryGuest
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string|null $role
     * @return PlannerEntryGuest
     */
    public function setRole(?string $role): PlannerEntryGuest
    {
        $this->role = in_array($role, self::getRoleList()) ? $role : null ;
        return $this;
    }

    /**
     * @return array
     */
    public static function getRoleList(): array
    {
        return self::$roleList;
    }
}