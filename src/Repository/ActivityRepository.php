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

use App\Entity\Activity;
use App\Entity\Person;
use App\Util\SchoolYearHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ActivityRepository
 * @package App\Repository
 */
class ActivityRepository extends ServiceEntityRepository
{
    /**
     * ActivityRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    /**
     * findByStaff
     * @param Person $person
     * @return array
     */
    public function findByStaff(Person $person): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a')
            ->leftJoin('a.staff', 'a_s')
            ->where('a_s.person = :person')
            ->setParameter('person', $person)
            ->andWhere('a.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
    }

    /**
     * findByStudent
     * @param Person $person
     * @return array
     */
    public function findByStudent(Person $person): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a')
            ->leftJoin('a.students', 'a_s')
            ->where('a_s.person = :person')
            ->setParameter('person', $person)
            ->andWhere('a.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
    }
}
