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

use App\Entity\DaysOfWeek;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class DaysOfWeekRepository
 * @package App\Repository
 */
class DaysOfWeekRepository extends ServiceEntityRepository
{
    /**
     * DaysOfWeekRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DaysOfWeek::class);
    }

    /**
     * @var array
     */
    private $daysOfWeek;

    /**
     * getDaysOfWeek
     * @return array
     */
    public function findAllAsArray(): array
    {
        if (! empty($this->daysOfWeek))
            return $this->daysOfWeek;
        $this->daysOfWeek = $this->createQueryBuilder('dow', 'dow.nameShort')
            ->getQuery()
            ->getArrayResult();
        return $this->daysOfWeek;
    }
}
