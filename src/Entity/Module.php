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
use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Module
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 * @ORM\Table(name="Module", uniqueConstraints={@ORM\UniqueConstraint(name="gibbonModuleName", columns={"name"})})
 * */
class Module implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonModuleID", columnDefinition="INT(4) UNSIGNED ZEROFILL", options={"comment": "This number is assigned at install, and is only unique to the installation"})
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=30, options={"comment": "This name should be globally unique preferably, but certainly locally unique"})
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(name="entryURL", options={"default": "index.php"})
     */
    private $entryURL;

    /**
     * @var string|null
     * @ORM\Column(length=12, options={"default": "Core"})
     */
    private $type = 'Core';

    /**
     * @var array
     */
    private static $typeList = ['Core', 'Additional'];

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $active = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=10)
     */
    private $category;

    /**
     * @var string|null
     * @ORM\Column(length=6)
     */
    private $version;

    /**
     * @var string|null
     * @ORM\Column(length=40)
     */
    private $author;

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
     * @return Module
     */
    public function setId(?int $id): Module
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
     * @return Module
     */
    public function setName(?string $name): Module
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Module
     */
    public function setDescription(?string $description): Module
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEntryURL(): ?string
    {
        return $this->entryURL;
    }

    /**
     * @param string|null $entryURL
     * @return Module
     */
    public function setEntryURL(?string $entryURL): Module
    {
        $this->entryURL = $entryURL;
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
     * @return Module
     */
    public function setType(?string $type): Module
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : 'Core' ;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * @param string|null $active
     * @return Module
     */
    public function setActive(?string $active): Module
    {
        $this->active = self::checkBoolean($active);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return Module
     */
    public function setCategory(?string $category): Module
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @param string|null $version
     * @return Module
     */
    public function setVersion(?string $version): Module
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     * @return Module
     */
    public function setAuthor(?string $author): Module
    {
        $this->author = $author;
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
     * @return Module
     */
    public function setUrl(?string $url): Module
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