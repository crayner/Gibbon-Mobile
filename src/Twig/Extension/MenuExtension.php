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
 * Date: 8/12/2018
 * Time: 13:26
 */
namespace App\Twig\Extension;

use App\Manager\MenuManager;
use Twig\Extension\AbstractExtension;

/**
 * Class MenuExtension
 * @package App\Twig\Extension
 */
class MenuExtension extends AbstractExtension
{
    /**
     * @var NotificationTrayManager
     */
    private $manager;

    /**
     * @return string
     */
    public function getName()
    {
        return 'menu_extension';
    }

    /**
     * MenuExtension constructor.
     * @param MenuManager $manager
     */
    public function __construct(MenuManager $manager)
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
            new \Twig_SimpleFunction('getMenuItems', array($this->manager, 'getMenuItems'), ['is_safe' => ['html']]),
        ];
    }
}