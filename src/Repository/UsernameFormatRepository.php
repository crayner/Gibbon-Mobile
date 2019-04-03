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
 * Time: 22:19
 */
namespace App\Repository;

use App\Entity\UsernameFormat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class UsernameFormatRepository
 * @package App\Repository
 */
class UsernameFormatRepository extends ServiceEntityRepository
{
    /**
     * UsernameFormatRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UsernameFormat::class);
    }
}
