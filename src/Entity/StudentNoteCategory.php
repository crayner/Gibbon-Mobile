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
 * Time: 16:22
 */

namespace App\Entity;

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class StudentNoteCategory
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StudentNoteCategoryRepository")
 * @ORM\Table(name="StudentNoteCategory")
 */
class StudentNoteCategory
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonStudentNoteCategoryID", columnDefinition="INT(5) UNSIGNED ZEROFILL")
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
     * @ORM\Column(type="text")
     */
    private $template;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $active = 'Y';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return StudentNoteCategory
     */
    public function setId(?int $id): StudentNoteCategory
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
     * @return StudentNoteCategory
     */
    public function setName(?string $name): StudentNoteCategory
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * @param string|null $template
     * @return StudentNoteCategory
     */
    public function setTemplate(?string $template): StudentNoteCategory
    {
        $this->template = $template;
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
     * @return StudentNoteCategory
     */
    public function setActive(?string $active): StudentNoteCategory
    {
        $this->active = self::checkBoolean($active);
        return $this;
    }
}