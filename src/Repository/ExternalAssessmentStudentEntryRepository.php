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

use App\Entity\ExternalAssessmentStudentEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ExternalAssessmentStudentEntryRepository
 * @package App\Repository
 */
class ExternalAssessmentStudentEntryRepository extends ServiceEntityRepository
{
    /**
     * ExternalAssessmentStudentEntryRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExternalAssessmentStudentEntry::class);
    }
}
