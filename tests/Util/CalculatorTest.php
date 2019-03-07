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
 * Date: 7/03/2019
 * Time: 12:49
 */
namespace App\Tests\Util;

use App\Manager\SettingManager;
use App\Manager\VersionManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CalculatorTest
 * @package App\Tests\Util
 */
class CalculatorTest extends WebTestCase
{
    public function testVersion()
    {
        self::bootKernel();

        // returns the real and unchanged service container
        // $container = self::$kernel->getContainer();

        // gets the special container that allows fetching private services
        $container = self::$container;

        $versionManager = $container->get(VersionManager::class);
        $versionManager->setSettingManager($container->get(SettingManager::class));

        $this->assertEquals(true, $versionManager->checkVersion(), $versionManager->getGibbonVersionStatus());

        $details = $versionManager->getGibbonDetails();

        // assert that the Gibbon Version is Correct.
        $this->assertEquals('18.0.00', $details['version']);
        $this->assertEquals(true, $details['cuttingEdge']);
        $this->assertEquals(32, $details['cuttingEdgeLineFound']);
    }
}
