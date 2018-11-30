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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class YearGroup
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\YearGroupRepository")
 * @ORM\Table(name="YearGroup")
 */
class YearGroup
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonYearGroupID", columnDefinition="INT(3) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;
}