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
 * Time: 22:19
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UsernameFormat
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UsernameFormatRepository")
 * @ORM\Table(name="UsernameFormat")
 */
class UsernameFormat implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonUsernameFormatID", columnDefinition="INT(3) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(name="gibbonRoleIDList", nullable=true)
     */
    private $roleList;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    private $format;

    /**
     * @var string|null
     * @ORM\Column(name="isDefault", length=1, options={"default": "N"})
     */
    private $isDefault = 'N';

    /**
     * @var string|null
     * @ORM\Column(name="isNumeric", length=1, options={"default": "N"})
     */
    private $isNumeric = 'N';

    /**
     * @var integer|null
     * @ORM\Column(name="numericValue", type="bigint", columnDefinition="INT(12) UNSIGNED", options={"default": "0"})
     */
    private $numericValue = 0;

    /**
     * @var integer|null
     * @ORM\Column(name="numericIncrement", type="smallint", columnDefinition="INT(3) UNSIGNED", options={"default": "1"})
     */
    private $numericIncrement = 1;

    /**
     * @var integer|null
     * @ORM\Column(name="numericSize", type="smallint", columnDefinition="INT(3) UNSIGNED", options={"default": "4"})
     */
    private $numericSize = 4;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UsernameFormat
     */
    public function setId(?int $id): UsernameFormat
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoleList(): ?string
    {
        return $this->roleList;
    }

    /**
     * @param string|null $roleList
     * @return UsernameFormat
     */
    public function setRoleList(?string $roleList): UsernameFormat
    {
        $this->roleList = $roleList;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @param string|null $format
     * @return UsernameFormat
     */
    public function setFormat(?string $format): UsernameFormat
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getisDefault(): ?string
    {
        return $this->isDefault;
    }

    /**
     * @param string|null $isDefault
     * @return UsernameFormat
     */
    public function setIsDefault(?string $isDefault): UsernameFormat
    {
        $this->isDefault = self::checkBoolean($isDefault, 'N');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getisNumeric(): ?string
    {
        return $this->isNumeric;
    }

    /**
     * @param string|null $isNumeric
     * @return UsernameFormat
     */
    public function setIsNumeric(?string $isNumeric): UsernameFormat
    {
        $this->isNumeric = self::checkBoolean($isNumeric, 'N');
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumericValue(): ?int
    {
        return $this->numericValue;
    }

    /**
     * @param int|null $numericValue
     * @return UsernameFormat
     */
    public function setNumericValue(?int $numericValue): UsernameFormat
    {
        $this->numericValue = $numericValue;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumericIncrement(): ?int
    {
        return $this->numericIncrement;
    }

    /**
     * @param int|null $numericIncrement
     * @return UsernameFormat
     */
    public function setNumericIncrement(?int $numericIncrement): UsernameFormat
    {
        $this->numericIncrement = $numericIncrement;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumericSize(): ?int
    {
        return $this->numericSize;
    }

    /**
     * @param int|null $numericSize
     * @return UsernameFormat
     */
    public function setNumericSize(?int $numericSize): UsernameFormat
    {
        $this->numericSize = $numericSize;
        return $this;
    }
}