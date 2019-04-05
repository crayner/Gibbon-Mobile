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

use App\Entity\FamilyAdult;
use App\Entity\Person;
use App\Util\UserHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class FamilyAdultRepository
 * @package App\Repository
 */
class FamilyAdultRepository extends ServiceEntityRepository
{
    /**
     * FamilyAdultRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FamilyAdult::class);
    }

    /**
     * @param Person $parent
     * @return array
     */
    public function findChildrenByParent(Person $parent): array
    {
        $x = $this->createQueryBuilder('fa')
            ->leftJoin('fa.family', 'f')
            ->leftJoin('f.children', 'fc')
            ->leftJoin('fc.person', 'p')
            ->select('fa,f,fc,p')
            ->where('fa.person = :person')
            ->setParameter('person', $parent)
            ->getQuery()
            ->getResult();
        $results = [];
        foreach(($x ?: []) as $item) {
            foreach($item->getFamily()->getChildren() as $child)
                if ($child->getPerson())
                    $results[$child->getPerson()->getId()] = $child->getPerson();
        }
        return $results;
    }
}
