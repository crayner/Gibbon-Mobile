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
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 15:27
 */

namespace App\Entity;

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ExternalAssessment
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ExternalAssessmentRepository")
 * @ORM\Table(name="ExternalAssessment")
 */
class ExternalAssessment
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="smallint", name="gibbonExternalAssessmentID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
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
     * @ORM\Column(length=10, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $website;

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $active = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=1, name="allowFileUpload", options={"default": "N"})
     */
    private $allowFileUpload = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ExternalAssessment
     */
    public function setId(?int $id): ExternalAssessment
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
     * @return ExternalAssessment
     */
    public function setName(?string $name): ExternalAssessment
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameShort(): ?string
    {
        return $this->nameShort;
    }

    /**
     * @param string|null $nameShort
     * @return ExternalAssessment
     */
    public function setNameShort(?string $nameShort): ExternalAssessment
    {
        $this->nameShort = $nameShort;
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
     * @return ExternalAssessment
     */
    public function setDescription(?string $description): ExternalAssessment
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string|null $website
     * @return ExternalAssessment
     */
    public function setWebsite(?string $website): ExternalAssessment
    {
        $this->website = $website;
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
     * @return ExternalAssessment
     */
    public function setActive(?string $active): ExternalAssessment
    {
        $this->active = self::checkBoolean($active, 'N');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAllowFileUpload(): ?string
    {
        return $this->allowFileUpload;
    }

    /**
     * @param string|null $allowFileUpload
     * @return ExternalAssessment
     */
    public function setAllowFileUpload(?string $allowFileUpload): ExternalAssessment
    {
        $this->allowFileUpload = self::checkBoolean($allowFileUpload, 'N');
        return $this;
    }
}