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

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Permission
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PermissionRepository")
 * @ORM\Table(name="Permission", indexes={@ORM\Index(name="gibbonRoleID", columns={"gibbonRoleID"}), @ORM\Index(name="gibbonActionID", columns={"gibbonActionID"})})
 */
class Permission
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="permissionID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Role|null
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="gibbonRoleID", referencedColumnName="gibbonRoleID", nullable=false)
     */
    private $role;

    /**
     * @var Action|null
     * @ORM\ManyToOne(targetEntity="Action", inversedBy="permissions")
     * @ORM\JoinColumn(name="gibbonActionID", referencedColumnName="gibbonActionID", nullable=false)
     */
    private $action;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Permission
     */
    public function setId(?int $id): Permission
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * @param Role|null $role
     * @return Permission
     */
    public function setRole(?Role $role): Permission
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return Action|null
     */
    public function getAction(): ?Action
    {
        return $this->action;
    }

    /**
     * @param Action|null $action
     * @return Permission
     */
    public function setAction(?Action $action): Permission
    {
        $this->action = $action;
        return $this;
    }
}