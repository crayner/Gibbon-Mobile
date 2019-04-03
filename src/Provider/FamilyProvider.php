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
 * Time: 10:24
 */
namespace App\Provider;

use App\Entity\Family;
use App\Entity\FamilyChild;
use App\Entity\Person;
use App\Manager\Traits\EntityTrait;

/**
 * Class FamilyProvider
 * @package App\Provider
 */
class FamilyProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Family::class;
}