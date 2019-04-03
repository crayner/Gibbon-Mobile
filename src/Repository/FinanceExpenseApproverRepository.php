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

use App\Entity\FinanceExpenseApprover;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class FinanceExpenseApproverRepository
 * @package App\Repository
 */
class FinanceExpenseApproverRepository extends ServiceEntityRepository
{
    /**
     * FinanceExpenseApproverRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FinanceExpenseApprover::class);
    }
}
