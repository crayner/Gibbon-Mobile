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
 * Time: 16:28
 */
namespace App\Repository;

use App\Entity\StudentNoteCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class StudentNoteCategoryRepository
 * @package App\Repository
 */
class StudentNoteCategoryRepository extends ServiceEntityRepository
{
    /**
     * StudentNoteCategoryRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentNoteCategory::class);
    }
}
