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
 * Time: 22:02
 */
namespace App\Repository;

use App\Entity\UnitBlockStar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class UnitBlockStarRepository
 * @package App\Repository
 */
class UnitBlockStarRepository extends ServiceEntityRepository
{
    /**
     * UnitBlockStarRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UnitBlockStar::class);
    }
}
