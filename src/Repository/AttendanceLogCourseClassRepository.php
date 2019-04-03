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

use App\Entity\AttendanceLogCourseClass;
use App\Entity\CourseClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class AttendanceLogCourseClassRepository
 * @package App\Repository
 */
class AttendanceLogCourseClassRepository extends ServiceEntityRepository
{
    /**
     * AttendanceLogCourseClassRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AttendanceLogCourseClass::class);
    }

    /**
     * isAttendanceTaken
     * @param int $class
     * @param \DateTime $date
     * @return bool
     */
    public function isAttendanceTaken(int $class, \DateTime $date): bool
    {
        if (empty($this->createQueryBuilder('alcc')
            ->join('alcc.courseClass', 'cc')
            ->where('alcc.date = :date')
            ->setParameter('date', $date)
            ->andWhere('cc.id = :ccid')
            ->setParameter('ccid', $class)
            ->getQuery()
            ->getResult()))
            return false;
        return true;
    }
}
