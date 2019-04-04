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
        $this->assertEquals($details['cuttingEdgeLine'], $details['cuttingEdgeLineFound']);

        $path = realpath(__DIR__ . '/../../Gibbon/CHANGEDB.php');

        include $path;
        $changes = explode(';end', str_replace(["\r\n", "\n", "\r"], "", $sql[0][1]));
        foreach ($changes as $q=>$w)
            if (empty(trim($w)))
                unset($changes[$q]);

        // assert that the Gibbon Version is Correct.
        $this->assertEquals(count($changes), $details['cuttingEdgeLineFound'], 'You must update the CHANGES.php file in the "Gibbon" directory for Travis testing.');
    }
}
