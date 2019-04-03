<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 11/12/2018
 * Time: 13:11
 */
namespace App\Provider;

use App\Entity\UsernameFormat;
use App\Manager\Traits\EntityTrait;

/**
 * Class UsernameFormatProvider
 * @package App\Provider
 */
class UsernameFormatProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = UsernameFormat::class;
}