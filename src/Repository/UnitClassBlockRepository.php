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
 * Time: 22:09
 */
namespace App\Repository;

use App\Entity\UnitClassBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class UnitClassBlockRepository
 * @package App\Repository
 */
class UnitClassBlockRepository extends ServiceEntityRepository
{
    /**
     * UnitClassBlockRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UnitClassBlock::class);
    }
}
