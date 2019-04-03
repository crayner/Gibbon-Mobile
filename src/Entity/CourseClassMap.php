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
 * Class CourseClassMap
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CourseClassMapRepository")
 * @ORM\Table(name="CourseClassMap", uniqueConstraints={@ORM\UniqueConstraint(name="gibbonCourseClassID", columns={"gibbonCourseClassID"})})
 */
class CourseClassMap
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonCourseClassMapID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var CourseClass|null
     * @ORM\ManyToOne(targetEntity="CourseClass")
     * @ORM\JoinColumn(name="gibbonCourseClassID", referencedColumnName="gibbonCourseClassID", nullable=true)
     */
    private $courseClass;

    /**
     * @var RollGroup|null
     * @ORM\ManyToOne(targetEntity="RollGroup")
     * @ORM\JoinColumn(name="gibbonRollGroupID", referencedColumnName="gibbonRollGroupID", nullable=true)
     */
    private $rollGroup;

    /**
     * @var YearGroup|null
     * @ORM\ManyToOne(targetEntity="YearGroup")
     * @ORM\JoinColumn(name="gibbonYearGroupID", referencedColumnName="gibbonYearGroupID", nullable=true)
     */
    private $yearGroup;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return CourseClassMap
     */
    public function setId(?int $id): CourseClassMap
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return CourseClass|null
     */
    public function getCourseClass(): ?CourseClass
    {
        return $this->courseClass;
    }

    /**
     * @param CourseClass|null $courseClass
     * @return CourseClassMap
     */
    public function setCourseClass(?CourseClass $courseClass): CourseClassMap
    {
        $this->courseClass = $courseClass;
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
     * @return CourseClassMap
     */
    public function setRollGroup(?RollGroup $rollGroup): CourseClassMap
    {
        $this->rollGroup = $rollGroup;
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
     * @return CourseClassMap
     */
    public function setYearGroup(?YearGroup $yearGroup): CourseClassMap
    {
        $this->yearGroup = $yearGroup;
        return $this;
    }
}