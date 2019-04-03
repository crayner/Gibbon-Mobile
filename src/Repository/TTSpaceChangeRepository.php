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
 * Time: 17:26
 */
namespace App\Repository;

use App\Entity\TTSpaceChange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TTSpaceChangeRepository
 * @package App\Repository
 */
class TTSpaceChangeRepository extends ServiceEntityRepository
{
    /**
     * TTSpaceChangeRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TTSpaceChange::class);
    }
}
