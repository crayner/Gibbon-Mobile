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
use App\Entity\RollGroup;
use App\Entity\SchoolYear;
use App\Util\SchoolYearHelper;
use App\Util\UserHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class RollGroupRepository
 * @package App\Repository
 */
class RollGroupRepository extends ServiceEntityRepository
{
    /**
     * ApplicationFormRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RollGroup::class);
    }

    /**
     * findByTutor
     * @param Person $tutor
     * @return array
     */
    public function findByTutor(Person $tutor, ?SchoolYear $schoolYear): array
    {
        $schoolYear = $schoolYear ?: SchoolYearHelper::getCurrentSchoolYear();
        return $this->createQueryBuilder('rg')
            ->select('rg')
            ->where('rg.tutor = :person OR rg.tutor2 = :person OR rg.tutor3 = :person OR rg.assistant = :person OR rg.assistant2 = :person OR rg.assistant3 = :person')
            ->setParameter('person', $tutor)
            ->andWhere('rg.schoolYear = :schoolYear')
            ->setParameter('schoolYear', $schoolYear)
            ->getQuery()
            ->getResult();
    }

    /**
     * findByStudent
     * @param Person $person
     * @return array
     */
    public function findByStudent(Person $person, ?SchoolYear $schoolYear): array
    {
        $schoolYear = $schoolYear ?: SchoolYearHelper::getCurrentSchoolYear();
        return $this->createQueryBuilder('rg')
            ->select('rg')
            ->leftJoin('rg.studentEnrolments', 'se')
            ->where('se.person = :person')
            ->setParameter('person', $person)
            ->andWhere('rg.schoolYear = :schoolYear')
            ->setParameter('schoolYear', $schoolYear)
            ->getQuery()
            ->getResult();
    }

    /**
     * findOneByPersonSchoolYear
     * @param Person $person
     * @param SchoolYear $schoolYear
     * @return RollGroup|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByPersonSchoolYear(Person $person, SchoolYear $schoolYear): ?RollGroup
    {
        if (UserHelper::isStaff())
            return $this->findOneBy(['tutor' => $person, 'schoolYear' => $schoolYear]);
        return $this->findOneByStudent($person, $schoolYear);
    }

    /**
     * findOneByStudent
     * @param Person $person
     * @param SchoolYear|null $schoolYear
     * @return RollGroup|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByStudent(Person $person, ?SchoolYear $schoolYear): ?RollGroup
    {
        $schoolYear = $schoolYear ?: SchoolYearHelper::getCurrentSchoolYear();
        return $this->createQueryBuilder('rg')
            ->select('rg')
            ->leftJoin('rg.studentEnrolments', 'se')
            ->where('se.person = :person')
            ->setParameter('person', $person)
            ->andWhere('rg.schoolYear = :schoolYear')
            ->setParameter('schoolYear', $schoolYear)
            ->orderBy('se.rollOrder', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
