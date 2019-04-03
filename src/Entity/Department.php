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
 * Class Department
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 * @ORM\Table(name="Department")
 */
class Department
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="smallint", name="gibbonDepartmentID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(length=16, options={"default": "Learning Area"})
     */
    private $type = "Learning Area";

    /**
     * @var array
     */
    private static $typeList = ['Learning Area', 'Administration'];

    /**
     * @var string
     * @ORM\Column(length=40)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(length=4, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column(name="subjectListing")
     */
    private $subjectListing;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $blurb;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $logo;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Department
     */
    public function setId(?int $id): Department
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Department
     */
    public function setType(string $type): Department
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : 'Learning Area';
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Department
     */
    public function setName(string $name): Department
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameShort(): string
    {
        return $this->nameShort;
    }

    /**
     * @param string $nameShort
     * @return Department
     */
    public function setNameShort(string $nameShort): Department
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubjectListing(): ?string
    {
        return $this->subjectListing;
    }

    /**
     * @param string|null $subjectListing
     * @return Department
     */
    public function setSubjectListing(?string $subjectListing): Department
    {
        $this->subjectListing = $subjectListing;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBlurb(): ?string
    {
        return $this->blurb;
    }

    /**
     * @param string|null $blurb
     * @return Department
     */
    public function setBlurb(?string $blurb): Department
    {
        $this->blurb = $blurb;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     * @return Department
     */
    public function setLogo(?string $logo): Department
    {
        $this->logo = $logo;
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