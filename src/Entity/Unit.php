<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon, Flexible & Open School System
 * Copyright (C) 2010, Ross Parker
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the LICENCE file.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * Gibbon-Mobile
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
 * Class Unit
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UnitRepository")
 * @ORM\Table(name="Unit")
 */
class Unit implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonUnitID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Course|null
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumn(name="gibbonCourseID", referencedColumnName="gibbonCourseID", nullable=false)
     */
    private $course;

    /**
     * @var string|null
     * @ORM\Column(length=40)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $active = 'Y';

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $tags;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"comment": "Should this unit be included in curriculum maps and other summaries?", "default": "Y"})
     */
    private $map = 'Y';

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", options={"default": "0"}, columnDefinition="INT(2)")
     */
    private $ordering = 0;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $attachment;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $details;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $embeddable = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=50, nullable=true)
     */
    private $license;

    /**
     * @var string|null
     * @ORM\Column(length=1, name="sharedPublic", nullable=true)
     */
    private $sharedPublic;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $creator;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDLastEdit", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $lastEdit;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Unit
     */
    public function setId(?int $id): Unit
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Course|null
     */
    public function getCourse(): ?Course
    {
        return $this->course;
    }

    /**
     * @param Course|null $course
     * @return Unit
     */
    public function setCourse(?Course $course): Unit
    {
        $this->course = $course;
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
     * @return Unit
     */
    public function setName(?string $name): Unit
    {
        $this->name = $name;
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
     * @return Unit
     */
    public function setActive(?string $active): Unit
    {
        $this->active = self::checkBoolean($active);
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
     * @return Unit
     */
    public function setDescription(?string $description): Unit
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * @param string|null $tags
     * @return Unit
     */
    public function setTags(?string $tags): Unit
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMap(): ?string
    {
        return $this->map;
    }

    /**
     * @param string|null $map
     * @return Unit
     */
    public function setMap(?string $map): Unit
    {
        $this->map = self::checkBoolean($map);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrdering(): ?int
    {
        return $this->ordering;
    }

    /**
     * @param int|null $ordering
     * @return Unit
     */
    public function setOrdering(?int $ordering): Unit
    {
        $this->ordering = $ordering;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    /**
     * @param string|null $attachment
     * @return Unit
     */
    public function setAttachment(?string $attachment): Unit
    {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDetails(): ?string
    {
        return $this->details;
    }

    /**
     * @param string|null $details
     * @return Unit
     */
    public function setDetails(?string $details): Unit
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmbeddable(): ?string
    {
        return $this->embeddable;
    }

    /**
     * @param string|null $embeddable
     * @return Unit
     */
    public function setEmbeddable(?string $embeddable): Unit
    {
        $this->embeddable = self::checkBoolean($embeddable, 'N');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicense(): ?string
    {
        return $this->license;
    }

    /**
     * @param string|null $license
     * @return Unit
     */
    public function setLicense(?string $license): Unit
    {
        $this->license = $license;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSharedPublic(): ?string
    {
        return $this->sharedPublic;
    }

    /**
     * @param string|null $sharedPublic
     * @return Unit
     */
    public function setSharedPublic(?string $sharedPublic): Unit
    {
        $this->sharedPublic = self::checkBoolean($sharedPublic, null);
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getCreator(): ?Person
    {
        return $this->creator;
    }

    /**
     * @param Person|null $creator
     * @return Unit
     */
    public function setCreator(?Person $creator): Unit
    {
        $this->creator = $creator;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getLastEdit(): ?Person
    {
        return $this->lastEdit;
    }

    /**
     * @param Person|null $lastEdit
     * @return Unit
     */
    public function setLastEdit(?Person $lastEdit): Unit
    {
        $this->lastEdit = $lastEdit;
        return $this;
    }
}