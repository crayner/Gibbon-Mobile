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
 * Time: 12:18
 */
namespace App\Provider;

use App\Entity\Action;
use App\Manager\EntityProviderInterface;
use App\Manager\Traits\EntityTrait;

/**
 * Class ActionProvider
 * @package App\Provider
 */
class ActionProvider implements EntityProviderInterface
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Action::class;

    /**
     * findByURLListModuleRole
     * @param array $criteria
     * @return mixed
     * @throws \Exception
     */
    public function findByURLListModuleRole(array $criteria)
    {
        return $this->getRepository()->createQueryBuilder('a')
            ->join('a.permissions', 'p')
            ->join('p.role', 'r')
            ->where('a.URLList LIKE :name')
            ->andWhere('a.module = :module')
            ->andWhere('p.role = :role')
            ->andWhere('a.name LIKE :sub')
            ->setParameters($criteria)
            ->getQuery()
            ->getArrayResult();
    }
}