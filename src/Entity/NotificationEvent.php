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
 * Class NotificationEvent
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\NotificationEventRepository")
 * @ORM\Table(name="NotificationEvent", uniqueConstraints={@ORM\UniqueConstraint(name="event", columns={"event","moduleName"})})
 * */
class NotificationEvent
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonNotificationEventID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=90)
     */
    private $event;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="moduleName")
     */
    private $moduleName;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="actionName")
     */
    private $actionName;

    /**
     * @var string|null
     * @ORM\Column(length=12)
     */
    private $type = 'Core';

    /**
     * @var array
     */
    private static $typeList = ['Core', 'Additional', 'CLI'];

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $scopes = 'All';

    /**
     * @var string|null
     * @ORM\Column(length=1)
     */
    private $active = 'Y';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return NotificationEvent
     */
    public function setId(?int $id): NotificationEvent
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEvent(): ?string
    {
        return $this->event;
    }

    /**
     * @param string|null $event
     * @return NotificationEvent
     */
    public function setEvent(?string $event): NotificationEvent
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getModuleName(): ?string
    {
        return $this->moduleName;
    }

    /**
     * @param string|null $moduleName
     * @return NotificationEvent
     */
    public function setModuleName(?string $moduleName): NotificationEvent
    {
        $this->moduleName = $moduleName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionName(): ?string
    {
        return $this->actionName;
    }

    /**
     * @param string|null $actionName
     * @return NotificationEvent
     */
    public function setActionName(?string $actionName): NotificationEvent
    {
        $this->actionName = $actionName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return NotificationEvent
     */
    public function setType(?string $type): NotificationEvent
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : 'Core';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getScopes(): ?string
    {
        return $this->scopes;
    }

    /**
     * @param string|null $scopes
     * @return NotificationEvent
     */
    public function setScopes(?string $scopes): NotificationEvent
    {
        $this->scopes = $scopes ?: 'All';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * @param string|null $active
     * @return NotificationEvent
     */
    public function setActive(?string $active): NotificationEvent
    {
        $this->active = self::checkBoolean($active);
        return $this;
    }

    /**
     * @return array
     */
    public static function getTypeList(): array
    {
        return self::$typeList;
    }
}