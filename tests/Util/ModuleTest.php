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
 * Time: 17:20
 */
namespace App\Tests\Util;

use App\Entity\Module;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ModuleTest
 * @package App\Tests\Util
 */
class ModuleTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = self::$container
            ->get('doctrine')
            ->getManager();
    }

    /**
     * testCountActions
     */
    public function testCountModules()
    {
        $modules = $this->entityManager
            ->getRepository(Module::class)
            ->findBy(['type' => 'core'])
        ;

        $this->assertCount(23, $modules, 'Core Module count is not correct.');
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
