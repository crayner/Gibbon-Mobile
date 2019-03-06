<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 5/12/2018
 * Time: 16:11
 */
namespace App\Entity;

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class StudentEnrolment
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StudentEnrolmentRepository")
 * @ORM\Table(name="StudentEnrolment", indexes={@ORM\Index(name="gibbonSchoolYearID", columns={"gibbonSchoolYearID"}), @ORM\Index(name="gibbonYearGroupID", columns={"gibbonYearGroupID"}), @ORM\Index(name="gibbonRollGroupID", columns={"gibbonRollGroupID"}), @ORM\Index(name="gibbonPersonIndex", columns={"gibbonPersonID","gibbonSchoolYearID"})})
 */
class StudentEnrolment
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonStudentEnrolmentID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID",referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $person;

    /**
     * @var SchoolYear|null
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(name="gibbonSchoolYearID", referencedColumnName="gibbonSchoolYearID", nullable=false)
     *
     */
    private $schoolYear;

    /**
     * @var YearGroup|null
     * @ORM\ManyToOne(targetEntity="YearGroup")
     * @ORM\JoinColumn(name="gibbonYearGroupID",referencedColumnName="gibbonYearGroupID", nullable=false)
     */
    private $yearGroup;

    /**
     * @var RollGroup|null
     * @ORM\ManyToOne(targetEntity="RollGroup", inversedBy="studentEnrolments")
     * @ORM\JoinColumn(name="gibbonRollGroupID", referencedColumnName="gibbonRollGroupID", nullable=false)
     */
    private $rollGroup;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", nullable=true, name="rollOrder", columnDefinition="INT(2)")
     */
    private $rollOrder;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return StudentEnrolment
     */
    public function setId(?int $id): StudentEnrolment
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
     * @return StudentEnrolment
     */
    public function setPerson(?Person $person): StudentEnrolment
    {
        $this->person = $person;
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
     * @return StudentEnrolment
     */
    public function setSchoolYear(?SchoolYear $schoolYear): StudentEnrolment
    {
        $this->schoolYear = $schoolYear;
        return $this;
    }

    /**
     * @return YearGroup|null
     */
    public function getYearGroup(): ?YearGroup
    {
        return $this->yearGroup;
    }

    /**
     * @param YearGroup|null $yearGroup
     * @return StudentEnrolment
     */
    public function setYearGroup(?YearGroup $yearGroup): StudentEnrolment
    {
        $this->yearGroup = $yearGroup;
        return $this;
    }

    /**
     * @return RollGroup|null
     */
    public function getRollGroup(): ?RollGroup
    {
        return $this->rollGroup;
    }

    /**
     * @param RollGroup|null $rollGroup
     * @return StudentEnrolment
     */
    public function setRollGroup(?RollGroup $rollGroup): StudentEnrolment
    {
        $this->rollGroup = $rollGroup;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRollOrder(): ?int
    {
        return $this->rollOrder;
    }

    /**
     * @param int|null $rollOrder
     * @return StudentEnrolment
     */
    public function setRollOrder(?int $rollOrder): StudentEnrolment
    {
        $this->rollOrder = $rollOrder;
        return $this;
    }
}