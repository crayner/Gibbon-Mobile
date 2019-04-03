<?php
/**
 * Created by PhpStorm.
 *
* Gibbon-Responsive
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 11:56
 */
namespace App\Entity;

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class I18n
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\I18nRepository")
 * @ORM\Table(name="i18n")
 */
class I18n
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibboni18nID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=5)
     */
    private $code;

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=10, nullable=true)
     */
    private $version;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $active = 'Y';

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $installed = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="systemDefault", options={"default": "N"})
     */
    private $systemDefault = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=20, name="dateFormat")
     */
    private $dateFormat;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="dateFormatRegEx")
     */
    private $dateFormatRegEx;

    /**
     * @var string|null
     * @ORM\Column(length=20, name="dateFormatPHP")
     */
    private $dateFormatPHP;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $rtl = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return I18n
     */
    public function setId(?int $id): I18n
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return I18n
     */
    public function setCode(?string $code): I18n
    {
        $this->code = $code;
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
     * @return I18n
     */
    public function setName(?string $name): I18n
    {
        $this->name = $name;
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
     * @return I18n
     */
    public function setVersion(?string $version): I18n
    {
        $this->version = $version;
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
     * @return I18n
     */
    public function setActive(?string $active): I18n
    {
        $this->active = self::checkBoolean($active, 'Y');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstalled(): ?string
    {
        return $this->installed;
    }

    /**
     * @param string|null $installed
     * @return I18n
     */
    public function setInstalled(?string $installed): I18n
    {
        $this->installed = self::checkBoolean($installed, 'N');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSystemDefault(): ?string
    {
        return $this->systemDefault;
    }

    /**
     * @param string|null $systemDefault
     * @return I18n
     */
    public function setSystemDefault(?string $systemDefault): I18n
    {
        $this->systemDefault = self::checkBoolean($systemDefault, 'N');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateFormat(): ?string
    {
        return $this->dateFormat;
    }

    /**
     * @param string|null $dateFormat
     * @return I18n
     */
    public function setDateFormat(?string $dateFormat): I18n
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateFormatRegEx(): ?string
    {
        return $this->dateFormatRegEx;
    }

    /**
     * @param string|null $dateFormatRegEx
     * @return I18n
     */
    public function setDateFormatRegEx(?string $dateFormatRegEx): I18n
    {
        $this->dateFormatRegEx = $dateFormatRegEx;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateFormatPHP(): ?string
    {
        return $this->dateFormatPHP;
    }

    /**
     * @param string|null $dateFormatPHP
     * @return I18n
     */
    public function setDateFormatPHP(?string $dateFormatPHP): I18n
    {
        $this->dateFormatPHP = $dateFormatPHP;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRtl(): ?string
    {
        return $this->rtl;
    }

    /**
     * @param string|null $rtl
     * @return I18n
     */
    public function setRtl(?string $rtl): I18n
    {
        $this->rtl = self::checkBoolean($rtl, 'N');
        return $this;
    }
}