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
 * Date: 11/12/2018
 * Time: 13:09
 */

namespace App\Twig\Extension;

use App\Manager\SettingManager;
use App\Provider\I18nProvider;
use App\Provider\UsernameFormatProvider;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;

/**
 * Class FormatExtension
 * @package App\Twig\Extension
 */
class FormatExtension extends AbstractExtension
{
    /**
     * @var SettingManager
     */
    private $manager;

    /**
     * @var UsernameFormatProvider
     */
    private $formatProvider;

    /**
     * @var I18nProvider
     */
    private $i18nProvider;

    /**
     * @var RequestStack
     */
    private $stack;

    /**
     * FormatExtension constructor.
     * @param SettingManager $manager
     * @param UsernameFormatProvider $formatProvider
     */
    public function __construct(SettingManager $manager, UsernameFormatProvider $formatProvider, I18nProvider $i18nProvider)
    {
        $this->manager = $manager;
        $this->formatProvider =  $formatProvider;
        $this->i18nProvider = $i18nProvider;
    }
    /**
     * getFunctions
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('dateFormat', array($this->i18nProvider, 'getDateFormatPHP')),
        ];
    }
}