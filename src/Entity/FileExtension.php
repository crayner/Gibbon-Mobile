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
 * Class FileExtension
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FileExtensionRepository")
 * @ORM\Table(name="FileExtension")
 */
class FileExtension
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonFileExtensionID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(length=16, options={"default": "Other"})
     */
    private $type = 'Other';

    /**
     * @var array
     */
    private static $typeList = ['Document','Spreadsheet','Presentation','Graphics/Design','Video','Audio','Other'];

    /**
     * @var string|null
     * @ORM\Column(length=7)
     */
    private $extension;

    /**
     * @var string|null
     * @ORM\Column(length=50)
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
     * @return FileExtension
     */
    public function setId(?int $id): FileExtension
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
     * setType
     * @param string $type
     * @return FileExtension
     */
    public function setType(string $type): FileExtension
    {
        $this->type = in_array($type,self::getTypeList()) ? $type : 'Other';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * @param string|null $extension
     * @return FileExtension
     */
    public function setExtension(?string $extension): FileExtension
    {
        $this->extension = $extension;
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
     * @return FileExtension
     */
    public function setName(?string $name): FileExtension
    {
        $this->name = $name;
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