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
 * Time: 17:13
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TTImport
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TTImportRepository")
 * @ORM\Table(name="TTImport")
 */
class TTImport implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonTTImportID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=6, name="courseNameShort")
     */
    private $courseNameShort;

    /**
     * @var string|null
     * @ORM\Column(length=5, name="classNameShort")
     */
    private $classNameShort;

    /**
     * @var string|null
     * @ORM\Column(length=12, name="dayName")
     */
    private $dayName;

    /**
     * @var string|null
     * @ORM\Column(length=12, name="rowName")
     */
    private $rowName;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="teacherUsernameList")
     */
    private $teacherUsernameList;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="spaceName")
     */
    private $spaceName;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TTImport
     */
    public function setId(?int $id): TTImport
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCourseNameShort(): ?string
    {
        return $this->courseNameShort;
    }

    /**
     * @param string|null $courseNameShort
     * @return TTImport
     */
    public function setCourseNameShort(?string $courseNameShort): TTImport
    {
        $this->courseNameShort = $courseNameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClassNameShort(): ?string
    {
        return $this->classNameShort;
    }

    /**
     * @param string|null $classNameShort
     * @return TTImport
     */
    public function setClassNameShort(?string $classNameShort): TTImport
    {
        $this->classNameShort = $classNameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDayName(): ?string
    {
        return $this->dayName;
    }

    /**
     * @param string|null $dayName
     * @return TTImport
     */
    public function setDayName(?string $dayName): TTImport
    {
        $this->dayName = $dayName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRowName(): ?string
    {
        return $this->rowName;
    }

    /**
     * @param string|null $rowName
     * @return TTImport
     */
    public function setRowName(?string $rowName): TTImport
    {
        $this->rowName = $rowName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTeacherUsernameList(): ?string
    {
        return $this->teacherUsernameList;
    }

    /**
     * @param string|null $teacherUsernameList
     * @return TTImport
     */
    public function setTeacherUsernameList(?string $teacherUsernameList): TTImport
    {
        $this->teacherUsernameList = $teacherUsernameList;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpaceName(): ?string
    {
        return $this->spaceName;
    }

    /**
     * @param string|null $spaceName
     * @return TTImport
     */
    public function setSpaceName(?string $spaceName): TTImport
    {
        $this->spaceName = $spaceName;
        return $this;
    }
}