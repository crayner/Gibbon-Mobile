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

use App\Entity\Person;
use App\Entity\PlannerEntry;
use App\Entity\SchoolYear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class PlannerEntryRepository
 * @package App\Repository
 */
class PlannerEntryRepository extends ServiceEntityRepository
{
    /**
     * ApplicationFormRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlannerEntry::class);
    }

    /**
     * getStaffDashboardContent
     * @param string $timezone
     * @return mixed
     * @throws \Exception
     */
    public function findStaffDashboardContent(string $today, SchoolYear $schoolYear, Person $person)
    {
        $results = $this->createQueryBuilder('pe')
            ->select('pe, cc, c, ccp, sh')
            ->join('pe.courseClass', 'cc')
            ->join('cc.course', 'c')
            ->join('cc.courseClassPeople', 'ccp')
            ->leftJoin('pe.studentHomeworkEntries', 'sh', 'WITH', 'ccp.person = sh.person', 'pe.id')
            ->where('c.schoolYear = :schoolYear')
            ->setParameter('schoolYear', $schoolYear)
            ->andWhere('pe.date = :today')
            ->setParameter('today', $today)
            ->andWhere('ccp.person = :currentUser')
            ->setParameter('currentUser', $person)
            ->andWhere('ccp.role NOT IN (:notRoles)')
            ->setParameter('notRoles', ['Student - Left', 'Teacher - Left'], Connection::PARAM_STR_ARRAY)
            ->getQuery()
            ->getResult();

        // with UNION of

        return array_merge($results,
            $this->createQueryBuilder('pe')
                ->select('pe, cc, c, peg')
                ->join('pe.courseClass', 'cc')
                ->join('pe.plannerEntryGuests', 'peg')
                ->join('cc.course', 'c')
                ->where('c.schoolYear = :schoolYear')
                ->setParameter('schoolYear', $schoolYear)
                ->andWhere('pe.date = :today')
                ->setParameter('today', $today)
                ->andWhere('peg.person = :currentUser')
                ->setParameter('currentUser', $person)
                ->getQuery()
                ->getResult()
        );
    }

    /**
     * findStudentDashboardContent
     * @param string $today
     * @param SchoolYear $schoolYear
     * @param Person $person
     * @return array
     */
    public function findStudentDashboardContent(string $today, SchoolYear $schoolYear, Person $person)
    {
        $today = '2019-04-29';
        $results = $this->createQueryBuilder('pe')
            ->select('pe', 'cc', 'ccp', 'c', 'sh')
            ->join('pe.courseClass', 'cc')
            ->join('cc.course', 'c')
            ->join('cc.courseClassPeople', 'ccp')
            ->leftJoin('pe.studentHomeworkEntries', 'sh', 'WITH', 'ccp.person = sh.person', 'pe.id')
            ->where('c.schoolYear = :schoolYear')
            ->setParameter('schoolYear', $schoolYear)
            ->andWhere('ccp.person = :currentUser')
            ->setParameter('currentUser', $person)
            ->getQuery()
            ->getResult();

        // with UNION of

        return array_merge($results,
            $this->createQueryBuilder('pe')
                ->select('pe, cc, c, peg')
                ->join('pe.courseClass', 'cc')
                ->join('pe.plannerEntryGuests', 'peg')
                ->join('cc.course', 'c')
                ->where('c.schoolYear = :schoolYear')
                ->setParameter('schoolYear', $schoolYear)
                ->andWhere('pe.date = :today')
                ->setParameter('today', $today)
                ->andWhere('peg.person = :currentUser')
                ->setParameter('currentUser', $person)
                ->getQuery()
                ->getResult()
        );
   }
}
