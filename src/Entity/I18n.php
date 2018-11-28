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
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 11:56
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class I18n
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\I18nRepository")
 * @ORM\Table(name="i18n")
 */
class I18n
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibboni18nID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
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
     * @return I18n
     */
    public function setId(?int $id): I18n
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=5, nullable=true)
     */
    private $code;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * setCode
     *
     * @param string|null $code
     * @return I18n
     */
    public function setCode(?string $code): I18n
    {
        $this->code = mb_substr($code, 0, 5);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=100, nullable=true)
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
     * setName
     *
     * @param string|null $name
     * @return I18n
     */
    public function setName(?string $name): I18n
    {
        $this->name = mb_substr($name, 0, 100);
        return $this;
    }
}