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
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * UserProvider: craig
 * Date: 25/11/2018
 * Time: 10:00
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Setting
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SettingRepository")
 * @ORM\Table(name="Setting", uniqueConstraints={@ORM\UniqueConstraint(name="scope", columns={"scope","nameDisplay"}), @ORM\UniqueConstraint(name="scope_2", columns={"scope","name"})})
 */
class Setting implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonSettingID", columnDefinition="INT(5) UNSIGNED ZEROFILL")
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
     * @return Setting
     */
    public function setId(?int $id): Setting
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $scope;

    /**
     * @return string|null
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * @param string|null $scope
     * @return Setting
     */
    public function setScope(?string $scope): Setting
    {
        $this->scope = mb_substr($scope, 0, 50);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Setting
     */
    public function setName(?string $name): Setting
    {
        $this->name = mb_substr($name, 0, 50);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=60, name="nameDisplay")
     */
    private $nameDisplay;

    /**
     * @return string|null
     */
    public function getNameDisplay(): ?string
    {
        return $this->nameDisplay;
    }

    /**
     * @param string|null $nameDisplay
     * @return Setting
     */
    public function setNameDisplay(?string $nameDisplay): Setting
    {
        $this->nameDisplay = mb_substr($nameDisplay, 0, 60);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $description;

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Setting
     */
    public function setDescription(?string $description): Setting
    {
        $this->description = mb_substr($description, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $value;

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return Setting
     */
    public function setValue(?string $value): Setting
    {
        $this->value = $value;
        return $this;
    }
}