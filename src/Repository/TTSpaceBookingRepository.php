<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon, Flexible & Open School System
 * Copyright (C) 2010, Ross Parker
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the LICENCE file.
 * If not, see <http://www.gnu.org/licenses/>.
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
use App\Manager\SettingManager;
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
