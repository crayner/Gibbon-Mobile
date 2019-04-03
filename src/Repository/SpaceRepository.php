<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Repository;

use App\Entity\Space;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class SpaceRepository
 * @package App\Repository
 */
class SpaceRepository extends ServiceEntityRepository
{
    /**
     * ApplicationFormRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Space::class);
    }

    /**
     * findAllIn
     * @param $spaces
     * Array of Space ID's
     * @return array
     */
    public function findAllIn($spaces): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.id IN (:spaces)')
            ->setParameter('spaces', $spaces, Connection::PARAM_INT_ARRAY)
            ->orderBy('s.name')
            ->getQuery()
            ->getResult();
    }
}
