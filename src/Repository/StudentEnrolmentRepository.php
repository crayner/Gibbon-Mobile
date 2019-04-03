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

use App\Entity\StudentEnrolment;
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
}
