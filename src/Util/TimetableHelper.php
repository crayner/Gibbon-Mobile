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
 * Date: 8/01/2019
 * Time: 13:21
 */

namespace App\Util;


use App\Entity\TTDayDate;
use App\Provider\TimetableProvider;

class TimetableHelper
{
    /**
     * @var TimetableProvider
     */
    private static $provider;

    /**
     * TimetableHelper constructor.
     * @param TimetableProvider $provider
     */
    public function __construct(TimetableProvider $provider)
    {
        self::$provider = $provider;
    }

    /**
     * isSchoolOpen
     * @param \DateTime $date
     * @return bool
     * @throws \Exception
     */
    public static function isSchoolOpen(\DateTime $date): bool
    {
        return self::$provider->getRepository(TTDayDate::class)->isSchoolOpen($date);
    }
}