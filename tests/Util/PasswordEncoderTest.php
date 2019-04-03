<?php
/**
 * Created by PhpStorm.
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
