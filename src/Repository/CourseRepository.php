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

use App\Entity\Course;
use App\Entity\Person;
use App\Util\SchoolYearHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class CourseRepository
 * @package App\Repository
 */
class CourseRepository extends ServiceEntityRepository
{
    /**
     * CourseRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @return array
     */
    public function findByPerson(Person $person): array
    {
        return $this->createQueryBuilder('c')
            ->select('DISTINCT c')
            ->leftJoin('c.courseClasses', 'cc')
            ->leftJoin('cc.courseClassPeople', 'ccp')
            ->where('ccp.person = :person')
            ->setParameter('person', $person)
            ->andWhere('c.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
    }
}
