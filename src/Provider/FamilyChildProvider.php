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
 * Time: 10:26
 */
namespace App\Provider;

use App\Entity\Family;
use App\Entity\FamilyChild;
use App\Entity\Person;
use App\Manager\EntityProviderInterface;
use App\Manager\Traits\EntityTrait;
use Doctrine\DBAL\Connection;

/**
 * Class FamilyChildProvider
 * @package App\Provider
 */
class FamilyChildProvider implements EntityProviderInterface
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = FamilyChild::class;

    /**
     * getChildrenFromParent
     * @param Person $person
     * @return array
     */
    public function getChildrenFromParent(Person $person): array
    {
        return $this->getRepository()->findByParent($person);
    }
}