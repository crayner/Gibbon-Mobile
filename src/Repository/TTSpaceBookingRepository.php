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
 * Time: 17:18
 */
namespace App\Repository;

use App\Entity\LibraryItem;
use App\Entity\Person;
use App\Entity\Space;
use App\Entity\TTSpaceBooking;
use App\Provider\SettingProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Else_;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TTSpaceBookingRepository
 * @package App\Repository
 */
class TTSpaceBookingRepository extends ServiceEntityRepository
{
    /**
     * TTSpaceBookingRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TTSpaceBooking::class);
    }

    /**
     * findByDatePerson
     * @param EntityManagerInterface $em
     * @param \DateTime $date
     * @param Person|null $person
     * @return array|null
     */
    public function findByDatePerson(\DateTime $date, ?Person $person = null): ?array
    {
        $x = $this->createQueryBuilder('tsb')
            ->where('tsb.date LIKE :date')
            ->setParameter('date', $date->format('Y-m-d').'%')
        ;

        if ($person)
            $x->andWhere('tsb.person = :person')
                ->setParameter('person', $person);

        $result = $x
            ->orderBy('tsb.date', 'ASC')
            ->addOrderBy('tsb.timeStart', 'ASC')
            ->getQuery()
            ->getResult();
        $spaces = [];
        $libraryItems = [];
        foreach($result as $entity)
            if ($entity->getForeignKey() === 'gibbonSpaceID')
                $spaces[] = $entity->getForeignKeyID();
            else
                $libraryItems[] = $entity->getForeignKeyID();
        $spaces = $this->getEntityManager()->getRepository(Space::class)->findAllIn($spaces);
        $libraryItems = $this->getEntityManager()->getRepository(LibraryItem::class)->findAllIn($libraryItems);
        foreach($result AS $booking)
            if ($entity->getForeignKey() === 'gibbonSpaceID')
                $entity->setSpace($this->filterEntity($spaces, $entity->getForeignKeyID()));
            else
                $entity->setLibraryItem($this->filterEntity($libraryItems, $entity->getForeignKeyID()));

        return $result;
    }

    /**
     * filterEntity
     * @param array $entities
     * @param int $id
     * @return bool|mixed
     */
    private function filterEntity(array $entities, int $id)
    {
        foreach($entities as $entity)
            if ($entity->getId() === $id)
                return $entity;
        return false;
    }
}
