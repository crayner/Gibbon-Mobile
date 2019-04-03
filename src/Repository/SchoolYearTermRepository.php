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

use App\Entity\SchoolYearTerm;
use App\Util\SchoolYearHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class SchoolYearTermRepository
 * @package App\Repository
 */
class SchoolYearTermRepository extends ServiceEntityRepository
{
    /**
     * ApplicationFormRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SchoolYearTerm::class);
    }

    /**
     * isDayInTerm
     * @param \DateTime $date
     * @return bool
     */
    public function isDayInTerm(\DateTime $date): bool
    {
        if ($this->createQueryBuilder('syt')
                ->select('COUNT(syt)')
                ->where('syt.firstDay <= :date and syt.lastDay >= :date')
                ->andWhere('syt.schoolYear = :schoolYear')
                ->setParameters(['schoolYear' => SchoolYearHelper::getCurrentSchoolYear(), 'date' => $date])
                ->getQuery()
                ->getSingleScalarResult() > 0)
            return true;
        return false;
    }

    /**
     * @param \DateTime $date
     * @return SchoolYearTerm|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByDay(\DateTime $date): ?SchoolYearTerm
    {
        return $this->createQueryBuilder('syt')
                ->where('syt.firstDay <= :date and syt.lastDay >= :date')
                ->andWhere('syt.schoolYear = :schoolYear')
                ->setParameters(['schoolYear' => SchoolYearHelper::getCurrentSchoolYear(), 'date' => $date])
                ->getQuery()
                ->getOneOrNullResult();
    }
}
