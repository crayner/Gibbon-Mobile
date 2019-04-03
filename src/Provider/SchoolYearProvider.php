<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 13/12/2018
 * Time: 12:06
 */
namespace App\Provider;

use App\Entity\SchoolYear;
use App\Manager\Traits\EntityTrait;

/**
 * Class SchoolYearProvider
 * @package App\Provider
 */
class SchoolYearProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = SchoolYear::class;
}