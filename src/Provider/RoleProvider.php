<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 7/12/2018
 * Time: 15:03
 */
namespace App\Provider;

use App\Entity\Role;
use App\Manager\Traits\EntityTrait;

/**
 * Class RoleProvider
 * @package App\Provider
 */
class RoleProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Role::class;

    /**
     * @var array
     */
    private $allRoles = [];

    /**
     * getRoleCategory
     * @param int $roleID
     * @return string
     */
    public function getRoleCategory(int $roleID): string
    {
        if (! empty($this->getAllRoles()[intval($roleID)]))
            return $this->getAllRoles()[intval($roleID)]->getCategory();
        return '';
    }

    /**
     * getAllRoles
     * @return array
     * @throws \Exception
     */
    public function getAllRoles(): array
    {
        if (empty($this->allRoles)) {
            $allRoles = $this->getRepository()->createQueryBuilder('r', 'r.id')
                ->getQuery()
                ->getResult() ?: [];
            foreach($allRoles as $q=>$role)
                $this->allRoles[intval($q)] = $role;
        }
        return $this->allRoles;
    }

    /**
     * additionalConstruct
     * @throws \Exception
     */
    private function additionalConstruct()
    {
        $this->getAllRoles();
    }
}