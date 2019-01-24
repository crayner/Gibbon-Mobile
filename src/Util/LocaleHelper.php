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
 * UserProvider: craig
 * Date: 24/11/2018
 * Time: 14:00
 */
namespace App\Util;

use App\Entity\Person;
use App\Provider\I18nProvider;

class LocaleHelper
{
    /**
     * @var string
     */
    private static $locale = 'en';

    /**
     * @var I18nProvider
     */
    private static $provider;

    /**
     * LocaleHelper constructor.
     * @param string $locale
     */
    public function __construct(I18nProvider $provider, string $locale = 'en')
    {
        self::$locale = self::getDefaultLocale($locale);
        self::$provider = $provider;
        $user = UserHelper::getCurrentUser();
        if ($user instanceof Person)
            self::$locale = ! empty($user->getI18nPersonal()) && ! empty($user->getI18nPersonal()->getCode()) ? $user->getI18nPersonal()->getCode() : self::$locale ;
    }

    /**
     * getLocale
     *
     * @return string
     */
    public static function getLocale(): string
    {
        return self::$locale;
    }

    /**
     * getDefaultLocale
     * @param string $locale
     * @return string
     */
    public static function getDefaultLocale(string $locale): string
    {
        if ($locale !== 'en' || empty(self::$provider))
            return $locale;
        return self::$provider->getRepository()->createQueryBuilder('i')
            ->where('i.systemDefault = :yes')
            ->setParameter('yes', 'Y')
            ->select('i.code')
            ->getQuery()
            ->getSingleScalarResult() ?: $locale;
    }
}