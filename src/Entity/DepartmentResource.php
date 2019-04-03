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
 * Class DepartmentResource
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentResourceRepository")
 * @ORM\Table(name="DepartmentResource")
 */
class DepartmentResource
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonDepartmentResourceID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Department|null
     * @ORM\ManyToOne(targetEntity="Department")
     * @ORM\JoinColumn(name="gibbonDepartmentID", referencedColumnName="gibbonDepartmentID", nullable=false)
     */
    private $department;

    /**
     * @var string
     * @ORM\Column(length=16)
     */
    private $type;

    /**
     * @var array
     */
    private static $typeList = ['Link', 'File'];

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $url;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return DepartmentResource
     */
    public function setId(?int $id): DepartmentResource
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Department|null
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    /**
     * @param Department|null $department
     * @return DepartmentResource
     */
    public function setDepartment(?Department $department): DepartmentResource
    {
        $this->department = $department;
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
     * @return DepartmentResource
     */
    public function setType(string $type): DepartmentResource
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : '';
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
     * @return DepartmentResource
     */
    public function setName(?string $name): DepartmentResource
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return DepartmentResource
     */
    public function setUrl(?string $url): DepartmentResource
    {
        $this->url = $url;
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