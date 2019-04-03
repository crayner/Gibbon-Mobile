<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 11:49
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Theme
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ThemeRepository")
 * @ORM\Table(name="Theme")
 */
class Theme implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonThemeID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $active = 'N';

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
     * @return Theme
     */
    public function setId(?int $id): Theme
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
     * @return Theme
     */
    public function setName(?string $name): Theme
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
     * @return Theme
     */
    public function setDescription(?string $description): Theme
    {
        $this->description = $description;
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
     * @return Theme
     */
    public function setActive(?string $active): Theme
    {
        $this->active = $active;
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
     * @return Theme
     */
    public function setVersion(?string $version): Theme
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
     * @return Theme
     */
    public function setAuthor(?string $author): Theme
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
     * @return Theme
     */
    public function setUrl(?string $url): Theme
    {
        $this->url = $url;
        return $this;
    }
}