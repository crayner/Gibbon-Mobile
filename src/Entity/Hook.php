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
 * Class Hook
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\HookRepository")
 * @ORM\Table(name="Hook", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name", "type"})})
 */
class Hook
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonHookID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=20, nullable=true)
     */
    private $type;

    /**
     * @var array 
     */
    private static $typeList = ['Public Home Page','Student Profile','Parental Dashboard','Staff Dashboard','Student Dashboard'];

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $options;

    /**
     * @var Module|null
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumn(name="gibbonModuleID", referencedColumnName="gibbonModuleID", nullable=false)
     */
    private $module;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Hook
     */
    public function setId(?int $id): Hook
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
     * @return Hook
     */
    public function setName(?string $name): Hook
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Hook
     */
    public function setType(?string $type): Hook
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : null ;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOptions(): ?string
    {
        return $this->options;
    }

    /**
     * @param string|null $options
     * @return Hook
     */
    public function setOptions(?string $options): Hook
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return Module|null
     */
    public function getModule(): ?Module
    {
        return $this->module;
    }

    /**
     * @param Module|null $module
     * @return Hook
     */
    public function setModule(?Module $module): Hook
    {
        $this->module = $module;
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