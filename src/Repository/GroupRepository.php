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

use App\Entity\Group;
use App\Entity\Person;
use App\Util\SchoolYearHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class GroupRepository
 * @package App\Repository
 */
class GroupRepository extends ServiceEntityRepository
{
    /**
     * GroupRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Group::class);
    }

    /**
     * findByPerson
     * @param Person $person
     * @return array
     */
    public function findByPerson(Person $person): array
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.people', 'gp')
            ->where('gp.person = :person')
            ->setParameter('person', $person)
            ->andWhere('g.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->getQuery()
            ->getResult();
    }
}
