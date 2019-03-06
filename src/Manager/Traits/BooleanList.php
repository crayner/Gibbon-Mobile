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
 * UserProvider: craig
 * Date: 24/11/2018
 * Time: 16:38
 */
namespace App\Manager\Traits;

/**
 * Trait BooleanList
 * @package App\Manager\Traits
 */
trait BooleanList
{
    /**
     * @var array
     */
    private static $booleanList = [
        'Y',
        'N',
    ];

    /**
     * getBooleanList
     * @return array
     */
    public static function getBooleanList(): array
    {
        return self::$booleanList;
    }

    /**
     * checkBoolean
     * @param string $value
     * @param string|null $default
     * @return string|null
     */
    private static function checkBoolean(string $value, ?string $default = 'Y')
    {
        return in_array($value, self::getBooleanList()) ? $value : $default;
    }

    /**
     * isTrueOrFalse
     * @param string $yesOrNo
     * @return bool
     */
    private function isTrueOrFalse(string $yesOrNo): bool
    {
        if ($yesOrNo === 'Y')
            return true;
        return false;
    }
}