<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 5/12/2018
 * Time: 16:57
 */
namespace App\Repository;

use App\Entity\TTDayDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TTDayDateRepository
 * @package App\Repository
 */
class TTDayDateRepository extends ServiceEntityRepository
{
    /**
     * TTDayDateRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TTDayDate::class);
    }

    /**
     * isSchoolOpen
     * @param \DateTime $date
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isSchoolOpen(\DateTime $date): bool
    {
       return (intval($this->createQueryBuilder('tdd')
                ->select('COUNT(tdd.id)')
                ->where('tdd.date LIKE :date')
                ->setParameter('date', $date->format('Y-m-d').'%')
                ->getQuery()
                ->getSingleScalarResult()) > 0) ? true : false ;
    }

    /**
     * findAllLikeDate
     * @param string $date
     * @return mixed
     */
    public function findAllLikeDate(string $date)
    {
        return $this->createQueryBuilder('tdd')
            ->where('tdd.date LIKE :date')
            ->setParameter('date', $date.'%')
            ->getQuery()
            ->getResult();
    }
}
