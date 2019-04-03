<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 12/12/2018
 * Time: 10:25
 */
namespace App\Provider;

use App\Entity\FamilyAdult;
use App\Manager\Traits\EntityTrait;

/**
 * Class FamilyAdultProvider
 * @package App\Provider
 */
class FamilyAdultProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = FamilyAdult::class;
}