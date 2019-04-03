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

use App\Entity\LibraryItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class LibraryItemRepository
 * @package App\Repository
 */
class LibraryItemRepository extends ServiceEntityRepository
{
    /**
     * ApplicationFormRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LibraryItem::class);
    }

    /**
     * findAllIn
     * @param $items
     * Array of item ID's
     * @return array
     */
    public function findAllIn($items): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.id IN (:items)')
            ->setParameter('items', $items, Connection::PARAM_INT_ARRAY)
            ->orderBy('s.name')
            ->getQuery()
            ->getResult();
    }
}
