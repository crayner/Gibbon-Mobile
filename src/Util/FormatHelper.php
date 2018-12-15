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
 * Date: 14/12/2018
 * Time: 15:53
 */
namespace App\Util;

use App\Entity\Person;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class FormatHelper
{
    /**
     * @var TranslatorInterface
     */
    private static $translator;

    /**
     * @var string
     */
    private static $gibbonUrl;

    /**
     * @var Packages
     */
    private static $assetPackages;

    /**
     * @var array
     */
    protected static $settings = [
        'dateFormatPHP'     => 'd/m/Y',
        'dateTimeFormatPHP' => 'd/m/Y H:i',
        'timeFormatPHP'     => 'H:i',
    ];

    /**
     * FormatHelper constructor.
     * @param TranslatorInterface $translator
     * @param ContainerInterface $container
     */
    public function __construct(TranslatorInterface $translator, ContainerInterface $container)
    {
        self::$translator = $translator;
        self::$gibbonUrl = $container->getParameter('gibbon_host_url');
    }

    /**
     * Formats a name based on the provided Role Category. Optionally reverses the name (surname first) or uses an informal format (no title).
     *
     * @param string $title
     * @param string $preferredName
     * @param string $surname
     * @param string $roleCategory
     * @param bool $reverse
     * @param bool $informal
     * @return string
     */
    public static function name($title, $preferredName, $surname, $roleCategory = 'Staff', $reverse = false, $informal = false)
    {
        $output = '';

        if (empty($preferredName) && empty($surname)) return '';

        if ($roleCategory == 'Staff' or $roleCategory == 'Other') {
            $setting = 'nameFormatStaff' . ($informal? 'Informal' : 'Formal') . ($reverse? 'Reversed' : '');
            $format = isset(self::$settings[$setting])? self::$settings[$setting] : '[title] [preferredName:1]. [surname]';

            $output = preg_replace_callback('/\[+([^\]]*)\]+/u',
                function ($matches) use ($title, $preferredName, $surname) {
                    list($token, $length) = array_pad(explode(':', $matches[1], 2), 2, false);
                    return isset($$token)
                        ? (!empty($length)? mb_substr($$token, 0, intval($length)) : $$token)
                        : '';
                },
                $format);

        } elseif ($roleCategory == 'Parent') {
            $format = (!$informal? '%1$s ' : '') . ($reverse? '%3$s, %2$s' : '%2$s %3$s');
            $output = sprintf($format, $title, $preferredName, $surname);
        } elseif ($roleCategory == 'Student') {
            $format = $reverse ? '%2$s, %1$s' : '%1$s %2$s';
            $output = sprintf($format, $preferredName, $surname);
        }

        return trim($output, ' ');
    }

    /**
     * renderImage
     * @param Person $person
     * @param int $dimension
     * @param bool $asHeight
     * @return string
     */
    public static function renderImage(Person $person, int $dimension = 75, bool $asHeight = false)
    {
        if ($asHeight)
            $size = 'height="'.intval($dimension).'px"';
        else
            $size = 'width="'.intval($dimension).'px"';

        if ($dimension === 0)
            $size = 'class="img-fluid"';

        $title = self::name($person->getTitle(), $person->getPreferredName(), $person->getSurname(), $person->getPrimaryRole()->getCategory());

        if (empty($person->getImage240()))
            $src = self::getAssetPackages()->getUrl('/build/static/DefaultPerson.png');
        else
            $src = self::getAssetPackages()->getUrl($person->getImage240(), 'gibbon');

        return sprintf('<img src="%s" alt="%s" %s />', $src, $title, $size);
    }

    /**
     * getAssetPackages
     * @return Packages
     */
    public static function getAssetPackages(): Packages
    {
        if (empty(self::$assetPackages))
            self::$assetPackages = new Packages(
                new Package(
                    new EmptyVersionStrategy()
                ),
                [
                    'gibbon' => new UrlPackage(
                        self::$gibbonUrl,
                        new EmptyVersionStrategy()
                    ),
                ]
            );
        return self::$assetPackages;
    }
}