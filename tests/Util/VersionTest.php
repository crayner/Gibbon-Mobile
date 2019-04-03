<?php
/**
 * Created by PhpStorm.
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

use App\Provider\SettingProvider;
use App\Manager\VersionManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class CalculatorTest
 * @package App\Tests\Util
 */
class VersionTest extends KernelTestCase
{
    public function testVersion()
    {
        self::bootKernel();

        // returns the real and unchanged service container
        //$container = self::$kernel->getContainer();

        // gets the special container that allows fetching private services
        $container = self::$container;

        $settingManager = $container->get(SettingProvider::class);
        $versionManager = $container->get(VersionManager::class);
        $versionManager->setSettingManager($settingManager);

        $this->assertEquals(true, $versionManager->checkVersion(), $versionManager->getGibbonVersionStatus());

        $details = $versionManager->getGibbonDetails();

        // assert that the Gibbon Version is Correct.
        $this->assertEquals('18.0.00', $details['version']);
        $this->assertEquals(true, $details['cuttingEdge']);
        $this->assertEquals(34, $details['cuttingEdgeLineFound']);
    }
}
