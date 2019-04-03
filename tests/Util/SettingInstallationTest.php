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
 * Date: 11/03/2019
 * Time: 11:06
 */
namespace App\Tests\Util;

use App\Entity\I18n;
use App\Manager\MessageManager;
use App\Provider\SettingProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * Class SettingInstallationTest
 * @package App\Tests\Util
 */
class SettingInstallationTest extends WebTestCase
{
    /**
     * @var SettingProvider
     */
    private $provider;

    private $session;

    /**
     * setUp
     * @throws \Exception
     */
    public function setUp(): void
    {
        self::bootKernel();

        $this->session = new Session(new MockArraySessionStorage());
        if (! $this->session->isStarted())
            $this->session->start();
        $mm = new MessageManager();
        $this->provider = new SettingProvider(self::$kernel->getContainer(), $mm);

    }

    public function testTimezoneSetting()
    {
        $this->assertEquals($this->provider->getParameter('timezone'), $this->provider->getSettingByScopeAsString('System', 'timezone', 'UTC'), 'The timezone has not been set correctly.');
    }

    public function testLocaleSetting()
    {
        $locale = $this->provider->getRepository(I18n::class)->createQueryBuilder('i')
            ->where('i.systemDefault = :yes')
            ->setParameter('yes', 'Y')
            ->select('i.code')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertEquals($locale, $this->provider->getParameter('locale'), sprintf('The locale has not been set correctly % != %s', $locale, $this->provider->getParameter('locale')));
        $this->assertContains(strval(strlen($locale)), '25', 'The length of the locale is not corrert.');
    }

    public function tearDown(): void
    {
        $this->provider = null;
        $this->session = null;
    }
}