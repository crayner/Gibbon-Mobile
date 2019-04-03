<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 19/12/2018
 * Time: 12:21
 */
namespace App\Provider;

use App\Entity\Module;
use App\Manager\EntityProviderInterface;
use App\Manager\Traits\EntityTrait;

/**
 * Class ModuleProvider
 * @package App\Provider
 */
class ModuleProvider implements EntityProviderInterface
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Module::class;
}