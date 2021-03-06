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
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Twig\Extension;

use App\Manager\SettingManager;
use App\Util\VersionHelper;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Extension\AbstractExtension;

/**
 * Class SettingExtension
 * @package App\Twig\Extension
 */
class SettingExtension extends AbstractExtension
{
    /**
     * @var SettingManager
     */
    private $manager;

    /**
     * SettingExtension constructor.
     * @param SettingManager $manager
     */
    public function __construct(SettingManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * getFunctions
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getSetting', array($this->manager, 'getSettingByScope')),
            new \Twig_SimpleFunction('getParameter', array($this->manager, 'getParameter')),
            new \Twig_SimpleFunction('getVersion', array($this, 'getVersion')),
            new \Twig_SimpleFunction('getGibbonVersion', array($this, 'getGibbonVersion')),
            new \Twig_SimpleFunction('clearCache', array($this, 'clearCache')),
        ];
    }

    /**
     * getVersion
     * @return string
     */
    public function getVersion(){
        return VersionHelper::VERSION;
    }

    /**
     * getGibbonVersion
     * @return string
     */
    public function getGibbonVersion(): string
    {
        return implode(',', VersionHelper::GIBBON);
    }

    /**
     * clearCache
     */
    public function clearCache()
    {
        $fs = new Filesystem();
        $fs->remove($this->manager->getContainer()->get('kernel')->getCacheDir());
        die();
    }
}