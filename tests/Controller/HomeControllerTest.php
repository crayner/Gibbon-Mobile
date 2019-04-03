<?php
/**
 * Created by PhpStorm.
 *
* Gibbon-Mobile
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 6/03/2019
 * Time: 16:51
 */
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class HomeControllerTest
 * @package App\Tests\Controller
 */
class HomeControllerTest extends WebTestCase
{
    /**
     * testHome
     */
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $x = 0;
        while ($client->getResponse()->getStatusCode() === 302 && $x < 5)
        {
            $crawler = $client->followRedirect();
            $x++;
        }

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
        $this->assertGreaterThan(
            0,
            $crawler->filter('body div.lead:contains("Login")')->count(),
            'The Login Form was not found.' . $client->getResponse()->getContent()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filterXPath('//*[@id="authenticate__username"]')->count(),
            'The username form element is missing'
        );
    }

    /**
     * testLoginFail
     */
    public function testLoginFail()
    {
        $client = static::createClient();

        $client->followRedirects();
        $crawler = $client->request('GET', '/en_GB/login/');

        $form = $crawler->filter('body button.btn')->form();
        $form['authenticate[_username]'] = 'craigray';
        $form['authenticate[_password]'] = 'sry93874ncS';  //wrong password
        $client->submit($form);

        $this->assertContains(
            'Authentication failed because App\Security\LoginFormAuthenticator::checkCredentials() did not return true.',
            $client->getResponse()->getContent()
        );
    }
}