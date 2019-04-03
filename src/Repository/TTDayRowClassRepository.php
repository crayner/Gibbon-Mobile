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
 * Time: 17:00
 */
namespace App\Repository;

use App\Entity\TTDay;
use App\Entity\TTDayRowClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TTDayRowClassRepository
 * @package App\Repository
 */
class TTDayRowClassRepository extends ServiceEntityRepository
{
    /**
     * TTDayRowClassRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TTDayRowClass::class);
    }

    /**
     * findByTTDay
     * @param TTDay $day
     * @return mixed
     */
    public function findByTTDay(TTDay $day)
    {
        return $this->createQueryBuilder('tdrc')
            ->where('tdrc.TTDay = :day')
            ->setParameter('day', $day)
            ->getQuery()
            ->getResult();
    }
}
