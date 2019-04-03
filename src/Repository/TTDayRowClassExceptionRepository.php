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
 * Time: 17:07
 */
namespace App\Repository;

use App\Entity\TTDayRowClassException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TTDayRowClassExceptionRepository
 * @package App\Repository
 */
class TTDayRowClassExceptionRepository extends ServiceEntityRepository
{
    /**
     * TTDayRowClassExceptionRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TTDayRowClassException::class);
    }
}
