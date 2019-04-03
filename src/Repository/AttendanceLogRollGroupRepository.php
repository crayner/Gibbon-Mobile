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

use App\Entity\AttendanceLogRollGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class AttendanceLogRollGroupRepository
 * @package App\Repository
 */
class AttendanceLogRollGroupRepository extends ServiceEntityRepository
{
    /**
     * AttendanceLogRollGroupRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AttendanceLogRollGroup::class);
    }

    /**
     * isAttendanceTaken
     * @param int $class
     * @param \DateTime $date
     * @return bool
     */
    public function isAttendanceTaken(int $roll, \DateTime $date): bool
    {
        if (empty($this->createQueryBuilder('alrg')
            ->join('alrg.rollGroup', 'rg')
            ->where('alrg.date = :date')
            ->setParameter('date', $date)
            ->andWhere('rg.id = :rgid')
            ->setParameter('rgid', $roll)
            ->getQuery()
            ->getResult()))
            return false;
        return true;
    }
}
