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

use App\Entity\AttendanceLogPerson;
use App\Entity\CourseClass;
use App\Entity\Person;
use App\Entity\RollGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class AttendanceLogPersonRepository
 * @package App\Repository
 */
class AttendanceLogPersonRepository extends ServiceEntityRepository
{
    /**
     * AttendanceLogPersonRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AttendanceLogPerson::class);
    }

    /**
     * findClassStudents
     * @param CourseClass $class
     * @param \DateTime $date
     * @return array
     */
    public function findClassStudents(CourseClass $class, \DateTime $date): array
    {
        $result = $this->createQueryBuilder('alp')
            ->select('alp, p')
            ->join('alp.person', 'p')
            ->where('alp.courseClass = :class')
            ->setParameter('class', $class)
            ->andWhere('alp.date = :currentDate')
            ->setParameter('currentDate', $date)
            ->andWhere('alp.context = :context')
            ->setParameter('context', 'Class')
            ->getQuery()
            ->getResult() ?: [];
        return $this->defineStudentListKeys($result);

    }

    /**
     * findRollStudents
     * @param \DateTime $date
     * @return array
     */
    public function findRollStudents(\DateTime $date): array
    {
        $result = $this->createQueryBuilder('alp')
            ->select('alp, p')
            ->join('alp.person', 'p')
            ->where('alp.date = :currentDate')
            ->setParameter('currentDate', $date)
            ->andWhere('alp.context = :context')
            ->setParameter('context', 'Roll Group')
            ->getQuery()
            ->getResult() ?: [];
        return $this->defineStudentListKeys($result);
    }

    /**
     * defineStudentListKeys
     * @param array $result
     * @return array
     */
    private function defineStudentListKeys(array $result): array
    {
        $students = [];
        foreach($result as $q=>$w)
        {
            $students[$w->getPerson()->getId()] = $w;
        }
        return $students;
    }

    /**
     * findByDateStudent
     * @param Person $person
     * @param string $showDate
     * @return array
     */
    public function findByDateStudent(Person $person, string $showDate): array
    {
        return $this->createQueryBuilder('alp')
            ->leftJoin('alp.studentEnrolment', 'se', 'WITH', 'alp.person = se.person')
            ->where('alp.person = :person')
            ->setParameter('person', $person)
            ->andWhere('alp.date = :showDate')
            ->setParameter('showDate', $showDate)
            ->getQuery()
            ->getResult();
    }
}
