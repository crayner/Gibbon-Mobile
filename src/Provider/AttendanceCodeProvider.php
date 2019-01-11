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
 * Date: 8/01/2019
 * Time: 10:57
 */
namespace App\Provider;

use App\Entity\AttendanceCode;
use App\Manager\Traits\EntityTrait;

/**
 * Class AttendanceCodeProvider
 * @package App\Provider
 */
class AttendanceCodeProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = AttendanceCode::class;

    /**
     * findActive
     * @return array
     * @throws \Exception
     */
    public function findActive(bool $asArray = false): array
    {
        return $this->getRepository()->findActive($asArray);
    }

    /**
     * @var array|null
     */
    private $selectArray;

    /**
     * createSelectArray
     * @return array
     * @throws \Exception
     */
    public function createSelectArray(): array
    {
        if (! empty($this->selectArray)) {
            $this->selectArray = [];
            foreach ($this->findActive() as $item) {
                $this->selectArray[$item->getId()] = $item->getName();
            }
        }
        return $this->selectArray;
    }
}