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
use App\Util\SchoolYearHelper;
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
    public function findByTutor(Person $tutor): array
    {
        return $this->createQueryBuilder('rg')
            ->select('rg')
            ->where('rg.tutor = :person OR rg.tutor2 = :person OR rg.tutor3 = :person OR rg.assistant = :person OR rg.assistant2 = :person OR rg.assistant3 = :person')
            ->setParameter('person', $tutor)
            ->andWhere('rg.schoolYear = :schoolYear')
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
        return $this->createQueryBuilder('rg')
            ->select('rg')
            ->leftJoin('rg.studentEnrolments', 'se')
            ->where('se.person = :person')
            ->setParameter('person', $person)
            ->andWhere('rg.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
    }
}
