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
 * Time: 16:10
 */
namespace App\Repository;

use App\Entity\Person;
use App\Entity\StudentEnrolment;
use App\Util\SchoolYearHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class StudentEnrolmentRepository
 * @package App\Repository
 */
class StudentEnrolmentRepository extends ServiceEntityRepository
{
    /**
     * StudentEnrolmentRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentEnrolment::class);
    }

    /**
     * @param Person $person
     * @return array
     */
    public function findStaffYearGroupsByRollGroup(Person $person): array
    {
        $x = $this->createQueryBuilder('se')
            ->select('DISTINCT yg.id AS yearGroupList')
            ->leftJoin('se.yearGroup', 'yg')
            ->leftJoin('se.rollGroup', 'rg')
            ->where('rg.tutor = :person OR rg.tutor2 = :person OR rg.tutor3 = :person')
            ->setParameter('person', $person)
            ->andWhere('se.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
        $results = [];
        foreach($x as $list)
            $results = array_merge($results, [str_pad($list['yearGroupList'],3, '0', STR_PAD_LEFT)]);

        return array_unique($results);
    }

    /**
     * @param Person $person
     * @return array
     */
    public function findStudentYearGroup(Person $person): array
    {
        $x = $this->createQueryBuilder('se')
            ->select('DISTINCT yg.id AS yearGroupList')
            ->leftJoin('se.yearGroup', 'yg')
            ->where('se.schoolYear = :schoolYear')
            ->andWhere('se.person = :person')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->setParameter('person', $person)
            ->getQuery()
            ->getResult();
        $results = [];
        foreach($x as $list)
            $results = array_merge($results, explode(',',$list['yearGroupList']));

        return array_unique($results);
    }
}
