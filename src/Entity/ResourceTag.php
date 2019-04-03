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
 * Class ResourceTag
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ResourceTagRepository")
 * @ORM\Table(name="ResourceTag", uniqueConstraints={@ORM\UniqueConstraint(name="tag", columns={"tag"})}, indexes={@ORM\Index(name="tag_2", columns={"tag"})})
 */
class ResourceTag
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonResourceTagID", columnDefinition="INT(12) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=100, unique=true)
     */
    private $tag;

    /**
     * @var integer|null
     * @ORM\Column(type="integer", columnDefinition="INT(6)")
     */
    private $count;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ResourceTag
     */
    public function setId(?int $id): ResourceTag
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param string|null $tag
     * @return ResourceTag
     */
    public function setTag(?string $tag): ResourceTag
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int|null $count
     * @return ResourceTag
     */
    public function setCount(?int $count): ResourceTag
    {
        $this->count = $count;
        return $this;
    }
}