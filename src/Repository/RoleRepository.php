<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 09:40
 */
namespace App\Repository;

use App\Entity\Person;
use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class RoleRepository
 * @package App\Repository
 */
class RoleRepository extends ServiceEntityRepository
{
    /**
     * RoleRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Role::class);
    }

    /**
     * findUserRoles
     * @param Person|null $person
     * @return array
     */
    public function findUserRoles(?Person $person): array
    {
        if (empty($person))
            return [];
        $roles = explode(',',$person->getAllRoles());
        $result = $this->createQueryBuilder('r')
            ->where('r.id IN (:roles)')
            ->setParameter('roles', $roles, Connection::PARAM_INT_ARRAY)
            ->getQuery()
            ->getResult();
        return $result ?: [];
    }
}
