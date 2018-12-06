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
 * Gibbon-Mobile
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 15:27
 */

namespace App\Entity;

use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Action
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 * @ORM\Table(name="Action",uniqueConstraints={@ORM\UniqueConstraint(name="moduleActionName", columns={"name", "gibbonModuleID"})}, indexes={@ORM\Index(name="gibbonModuleID", columns={"gibbonModuleID"})})
 */
class Action
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonActionID", columnDefinition="INT(7) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Action
     */
    public function setId(?int $id): Action
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var Module|null
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumn(name="gibbonModuleID",referencedColumnName="gibbonModuleID", nullable=false)
     */
    private $module;

    /**
     * @return Module|null
     */
    public function getModule(): ?Module
    {
        return $this->module;
    }

    /**
     * @param Module|null $module
     * @return Action
     */
    public function setModule(?Module $module): Action
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=50, options={"comment": "The action name should be unqiue to the module that it is related to"})
     */
    private $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Action
     */
    public function setName(?string $name): Action
    {
        $this->name = mb_substr($name, 0, 50);
        return $this;
    }

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", columnDefinition="INT(2)")
     */
    private $precedence;

    /**
     * @return int|null
     */
    public function getPrecedence(): ?int
    {
        return $this->precedence;
    }

    /**
     * @param int|null $precedence
     * @return Action
     */
    public function setPrecedence(?int $precedence): Action
    {
        $this->precedence = $precedence;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=20)
     */
    private $category;

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return Action
     */
    public function setCategory(?string $category): Action
    {
        $this->category = mb_substr($category, 0, 20);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255)
     */
    private $description;

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Action
     */
    public function setDescription(?string $description): Action
    {
        $this->description = mb_substr($description, 0, 255);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="text", name="URLList", options={"comment": "Comma seperated list of all URLs that make up this action"})
     */
    private $URLList;

    /**
     * @return string|null
     */
    public function getURLList(): ?string
    {
        return $this->URLList;
    }

    /**
     * @param string|null $URLList
     * @return Action
     */
    public function setURLList(?string $URLList): Action
    {
        $this->URLList = $URLList;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=255, name="entryURL")
     */
    private $entryURL;

    /**
     * @return string|null
     */
    public function getEntryURL(): ?string
    {
        return $this->entryURL;
    }

    /**
     * setEntryURL
     * @param string|null $entryURL
     * @return Action
     */
    public function setEntryURL(?string $entryURL): Action
    {
        $this->entryURL = mb_substr($entryURL, 0, 255);
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="entrySidebar", options={"default": "Y"})
     */
    private $entrySidebar = 'Y';

    /**
     * @return string
     */
    public function getEntrySidebar(): string
    {
        return $this->entrySidebar;
    }

    /**
     * @param string $entrySidebar
     * @return Action
     */
    public function setEntrySidebar(string $entrySidebar): Action
    {
        $this->entrySidebar = in_array($entrySidebar, self::getBooleanList()) ? $entrySidebar : 'Y';
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="menuShow", options={"default": "Y"})
     */
    private $menuShow = 'Y';

    /**
     * @return string
     */
    public function getMenuShow(): string
    {
        return $this->menuShow;
    }

    /**
     * @param string $menuShow
     * @return Action
     */
    public function setMenuShow(string $menuShow): Action
    {
        $this->menuShow = in_array($menuShow, self::getBooleanList()) ? $menuShow : 'Y';
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="defaultPermissionAdmin", options={"default": "N"})
     */
    private $defaultPermissionAdmin = 'N';

    /**
     * @return string
     */
    public function getDefaultPermissionAdmin(): string
    {
        return $this->defaultPermissionAdmin;
    }

    /**
     * @param string $defaultPermissionAdmin
     * @return Action
     */
    public function setDefaultPermissionAdmin(string $defaultPermissionAdmin): Action
    {
        $this->defaultPermissionAdmin = self::checkBoolean($defaultPermissionAdmin, 'N');
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="defaultPermissionTeacher", options={"default": "N"})
     */
    private $defaultPermissionTeacher = 'N';

    /**
     * @return string
     */
    public function getDefaultPermissionTeacher(): string
    {
        return $this->defaultPermissionTeacher;
    }

    /**
     * @param string $defaultPermissionTeacher
     * @return Action
     */
    public function setDefaultPermissionTeacher(string $defaultPermissionTeacher): Action
    {
        $this->defaultPermissionTeacher = self::checkBoolean($defaultPermissionTeacher, 'N');
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="defaultPermissionStudent", options={"default": "N"})
     */
    private $defaultPermissionStudent = 'N';

    /**
     * @return string
     */
    public function getDefaultPermissionStudent(): string
    {
        return $this->defaultPermissionStudent;
    }

    /**
     * @param string $defaultPermissionStudent
     * @return Action
     */
    public function setDefaultPermissionStudent(string $defaultPermissionStudent): Action
    {
        $this->defaultPermissionStudent = self::checkBoolean($defaultPermissionStudent, 'N');
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="defaultPermissionParent", options={"default": "N"})
     */
    private $defaultPermissionParent = 'N';

    /**
     * @return string
     */
    public function getDefaultPermissionParent(): string
    {
        return $this->defaultPermissionParent;
    }

    /**
     * @param string $defaultPermissionParent
     * @return Action
     */
    public function setDefaultPermissionParent(string $defaultPermissionParent): Action
    {
        $this->defaultPermissionParent = self::checkBoolean($defaultPermissionParent, 'N');
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="defaultPermissionSupport", options={"default": "N"})
     */
    private $defaultPermissionSupport = 'N';

    /**
     * @return string
     */
    public function getDefaultPermissionSupport(): string
    {
        return $this->defaultPermissionSupport;
    }

    /**
     * @param string $defaultPermissionSupport
     * @return Action
     */
    public function setDefaultPermissionSupport(string $defaultPermissionSupport): Action
    {
        $this->defaultPermissionSupport = self::checkBoolean($defaultPermissionSupport, 'N');
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="categoryPermissionStaff", options={"default": "Y"})
     */
    private $categoryPermissionStaff = 'Y';

    /**
     * @return string
     */
    public function getCategoryPermissionStaff(): string
    {
        return $this->categoryPermissionStaff;
    }

    /**
     * @param string $categoryPermissionStaff
     * @return Action
     */
    public function setCategoryPermissionStaff(string $categoryPermissionStaff): Action
    {
        $this->categoryPermissionStaff = self::checkBoolean($categoryPermissionStaff, 'Y');
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="categoryPermissionStudent", options={"default": "Y"})
     */
    private $categoryPermissionStudent = 'Y';

    /**
     * @return string
     */
    public function getCategoryPermissionStudent(): string
    {
        return $this->categoryPermissionStudent;
    }

    /**
     * @param string $categoryPermissionStudent
     * @return Action
     */
    public function setCategoryPermissionStudent(string $categoryPermissionStudent): Action
    {
        $this->categoryPermissionStudent = self::checkBoolean($categoryPermissionStudent, 'Y');
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="categoryPermissionParent", options={"default": "Y"})
     */
    private $categoryPermissionParent = 'Y';

    /**
     * @return string
     */
    public function getCategoryPermissionParent(): string
    {
        return $this->categoryPermissionParent;
    }

    /**
     * @param string $categoryPermissionParent
     * @return Action
     */
    public function setCategoryPermissionParent(string $categoryPermissionParent): Action
    {
        $this->categoryPermissionParent = self::checkBoolean($categoryPermissionParent, 'Y');
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(length=1, name="categoryPermissionOther", options={"default": "Y"})
     */
    private $categoryPermissionOther = 'Y';

    /**
     * @return string
     */
    public function getCategoryPermissionOther(): string
    {
        return $this->categoryPermissionOther;
    }

    /**
     * @param string $categoryPermissionOther
     * @return Action
     */
    public function setCategoryPermissionOther(string $categoryPermissionOther): Action
    {
        $this->categoryPermissionOther = self::checkBoolean($categoryPermissionOther, 'Y');
        return $this;
    }
}