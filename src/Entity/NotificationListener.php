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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class NotificationListener
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\NotificationListenerRepository")
 * @ORM\Table(name="NotificationListener")
 * */
class NotificationListener
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonNotificationListenerID", columnDefinition="INT(10) UNSIGNED ZEROFILL"})
     * @ORM\GeneratedValue
     */
    private $id;
    
    /**
     * @var NotificationEvent|null
     * @ORM\ManyToOne(targetEntity="NotificationEvent")
     * @ORM\JoinColumn(name="gibbonNotificationEventID", referencedColumnName="gibbonNotificationEventID", nullable=true)
     */
    private $notification;
    
    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonID", referencedColumnName="gibbonPersonID", nullable=true)
     */
    private $person;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="scopeType")
     */
    private $scopeType;

    /**
     * @var integer|null
     * @ORM\Column(type="bigint", name="scopeID", columnDefinition="INT(20) UNSIGNED")
     */
    private $scopeID;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return NotificationListener
     */
    public function setId(?int $id): NotificationListener
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return NotificationEvent|null
     */
    public function getNotification(): ?NotificationEvent
    {
        return $this->notification;
    }

    /**
     * @param NotificationEvent|null $notification
     * @return NotificationListener
     */
    public function setNotification(?NotificationEvent $notification): NotificationListener
    {
        $this->notification = $notification;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * @param Person|null $person
     * @return NotificationListener
     */
    public function setPerson(?Person $person): NotificationListener
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getScopeType(): ?string
    {
        return $this->scopeType;
    }

    /**
     * @param string|null $scopeType
     * @return NotificationListener
     */
    public function setScopeType(?string $scopeType): NotificationListener
    {
        $this->scopeType = $scopeType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getScopeID(): ?int
    {
        return $this->scopeID;
    }

    /**
     * @param int|null $scopeID
     * @return NotificationListener
     */
    public function setScopeID(?int $scopeID): NotificationListener
    {
        $this->scopeID = $scopeID;
        return $this;
    }
}