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
 * Date: 19/12/2018
 * Time: 10:03
 */
namespace App\Twig\Extension;

use App\Manager\DashboardInterface;
use Twig\Extension\AbstractExtension;

/**
 * Class TimetableExtension
 * @package App\Twig\Extension
 */
class TimetableExtension extends AbstractExtension
{
    /**
     * getName
     * @return string
     */
    public function getName()
    {
        return 'timetable_extension';
    }

    /**
     * getFunctions
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('hasTimetable', array($this, 'hasTimetable')),
        ];
    }

    /**
     * hasTimetable
     * @param $manager
     * @return bool
     */
    public function hasTimetable($manager): bool
    {
        if (method_exists($manager,'hasTimetable'))
            return $manager->hasTimetable();

        return false;
    }
}