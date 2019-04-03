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
 * Time: 16:52
 */
namespace App\Repository;

use App\Entity\TT;
use App\Entity\TTDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TTDayRepository
 * @package App\Repository
 */
class TTDayRepository extends ServiceEntityRepository
{
    /**
     * TTDayRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TTDay::class);
    }

    /**
     * findByDateTT
     * @param \DateTime $date
     * @param TT $tt
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByDateTT(\DateTime $date, TT $tt)
    {
        return $this->createQueryBuilder('td')
            ->select('td,tdd,tc,tcr')
            ->join('td.timetableDayDates', 'tdd')
            ->join('td.TTColumn', 'tc')
            ->join('tc.timetableColumnRows', 'tcr')
            ->where('tdd.date = :date')
            ->setParameter('date', $date)
            ->andWhere('td.TT = :timetable')
            ->setParameter('timetable', $tt)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
