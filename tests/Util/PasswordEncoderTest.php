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
 * Date: 8/03/2019
 * Time: 14:12
 */
namespace App\Tests\Util;

use App\Security\MD5PasswordEncoder;
use App\Security\SHA256PasswordEncoder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class PasswordEncoderTest
 * @package App\Tests\Util
 */
class PasswordEncoderTest extends KernelTestCase
{
    /**
     * testMD5Encoder
     */
    public function testMD5Encoder()
    {
        $encoder = new MD5PasswordEncoder();

        $this->assertEquals('36675c17336bcaf016e906a224a988cf', $encoder->encodePassword('gsfgsfrg765', ''));

        $this->assertTrue($encoder->isPasswordValid('36675c17336bcaf016e906a224a988cf', 'gsfgsfrg765', ''));
    }

    /**
     * testMD5Encoder
     */
    public function testSHA256Encoder()
    {
        $encoder = new SHA256PasswordEncoder();

        $this->assertEquals('36243569a7ce6088c8ebe2623c12f4d772510296998a2cc9f308f27f3d2e4757', $encoder->encodePassword('gsfgsfrg765', 'slglhj73456hv9p3uyrtervneeghr'));

        $this->assertTrue($encoder->isPasswordValid('36243569a7ce6088c8ebe2623c12f4d772510296998a2cc9f308f27f3d2e4757', 'gsfgsfrg765', 'slglhj73456hv9p3uyrtervneeghr'));
    }
}
