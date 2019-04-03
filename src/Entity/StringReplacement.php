<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * UserProvider: craig
 * Date: 24/11/2018
 * Time: 16:16
 */
namespace App\Entity;

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class StringReplacement
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StringReplacementRepository")
 * @ORM\Table(name="String")
 */
class StringReplacement
{
    use BooleanList;
    /**
     * @return array
     */
    public static function getModeList(): array
    {
        return self::$modeList;
    }

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonStringID", columnDefinition="INT(8) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return StringReplacement
     */
    public function setId(?int $id): StringReplacement
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $original;

    /**
     * @return string|null
     */
    public function getOriginal(): ?string
    {
        return $this->original;
    }

    /**
     * setOriginal
     *
     * @param string|null $original
     * @return StringOriginal
     */
    public function setOriginal(?string $original): StringReplacement
    {
        $this->original = mb_substr($original, 0, 100);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $replacement;

    /**
     * @return string|null
     */
    public function getReplacement(): ?string
    {
        return $this->replacement;
    }

    /**
     * setReplacement
     *
     * @param string|null $replacement
     * @return StringReplacement
     */
    public function setReplacement(?string $replacement): StringReplacement
    {
        $this->replacement = mb_substr($replacement, 0, 100);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=8)
     */
    private $mode;

    /**
     * @var array
     */
    private static $modeList = [
        'Whole',
        'Partial',
    ];

    /**
     * @return string|null
     */
    public function getMode(): ?string
    {
        return $this->mode;
    }

    /**
     * setMode
     *
     * @param string|null $mode
     * @return StringReplacement
     */
    public function setMode(?string $mode): StringReplacement
    {
        $this->mode = in_array($mode, self::getModeList()) ? $mode : null ;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=1, name="caseSensitive")
     */
    private $caseSensitive = 'N';

    /**
     * @return string|null
     */
    public function getCaseSensitive(): ?string
    {
        return $this->caseSensitive;
    }

    /**
     * setCaseSensitive
     *
     * @param string|null $caseSensitive
     * @return StringReplacement
     */
    public function setCaseSensitive(?string $caseSensitive): StringReplacement
    {
        $this->caseSensitive = in_array($caseSensitive, self::getBooleanList()) ? $caseSensitive : 'N' ;
        return $this;
    }

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", columnDefinition="INT(2)", options={"default": "0"})
     */
    private $priority;
}