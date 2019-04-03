<?php
/**
 * Created by PhpStorm.
 *
* Gibbon-Mobile
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 9/03/2019
 * Time: 12:07
 */
namespace App\Tests\Util;

use App\Entity\Action;
use App\Entity\Module;
use App\Entity\Person;
use App\Manager\MessageManager;
use App\Provider\ActionProvider;
use App\Repository\ActionRepository;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ProviderTest
 * @package App\Tests\Util
 */
class ProviderTest extends WebTestCase
{
    /**
     * testActionProvider
     * @throws \Exception
     */
    public function testActionProvider()
    {
        self::bootKernel();

        $provider = new ActionProvider(self::$container->get('doctrine')->getManager(), new MessageManager(), self::$container->get('security.authorization_checker'), self::$container->get('router'));
        $this->assertEquals(ActionProvider::class, get_class($provider), 'The provider class is not ' . ActionProvider::class);
        $this->assertEquals(Action::class, $provider->getEntityName(), 'The provider class is not set for ' . Action::class);
        $this->assertEquals(ActionRepository::class, get_class($provider->getRepository()), 'The repository class is not ' . ActionRepository::class);
        $this->assertEquals(PersonRepository::class, get_class($provider->getRepository(Person::class)), 'The repository class is not ' . PersonRepository::class);
        $module = $provider->getRepository(Module::class)->find(1);
        $this->assertEquals(Module::class, get_class($module), 'The provider did not provide Module ID = 1.');
        $this->assertCount(28, $provider->findBy(['module' => $module]), 'The provider did not provide the correct number of Actions for module ID = 1.');
        $action = $provider->findOneBy(['name' => 'Student Enrolment']);
        $this->assertEquals(Action::class, get_class($action), 'The provider did not provide Action Name = Student Enrolment.');
        $action = $provider->findAsArray($action);
        $this->assertEquals('Student Enrolment', $action['name'], 'The provider did not convert the entity to an array correctly.');
        $action = $provider->findOneBy(['name' => 'Student Enrolment']);
        $action->setPrecedence(5);
        $provider->saveEntity();
        $action = $provider->findAsArray($action);
        $this->assertEquals('5', $action['precedence'], 'The provider did not save the precedence in the Action correctly.');
        $action = $provider->findOneBy(['name' => 'Student Enrolment']);
        $action->setPrecedence(0);
        $provider->saveEntity();
        $action = $provider->findAsArray($action);
        $this->assertEquals('0', $action['precedence'], 'The provider did not restore the precedence in the Action correctly.');
        $this->assertEquals(Action::class, get_class($provider->getEntity()), 'The provider did not retrieve the entity Action correctly.');
    }
}
