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
 * Date: 9/12/2018
 * Time: 08:27
 */
namespace App\Manager;

use App\Entity\Notification;
use App\Manager\Objects\Notifications;
use App\Provider\NotificationProvider;
use Doctrine\DBAL\Exception\ConnectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class NotificationManager
 * @package App\Manager
 */
class NotificationManager
{
    /**
     * @var RequestStack
     */
    private $stack;

    /**
     * @var Request|null
     */
    private $request;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var NotificationProvider
     */
    private $provider;

    /**
     * @var Notifications|null
     */
    private $notifications;

    /**
     * @var SerializerInterface
     */
    private $serialiser;

    /**
     * @var bool|string|null
     */
    private $timezone = 'UTC';

    /**
     * NotificationManager constructor.
     * @param RequestStack $stack
     * @param NotificationProvider $provider
     * @param SettingManager $settingManager
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(RequestStack $stack, NotificationProvider $provider, SettingManager $settingManager)
    {
        $this->stack = $stack;
        $this->provider = $provider;

        try {
            $timezone = $settingManager->getSettingByScope('System', 'timezone');
        } catch (ConnectionException $e) {
            $timezone = 'UTC';
        }

        $this->setTimezone($timezone);
        $normalisers = [new DateTimeNormalizer(['datetime_timezone' => $this->getTimezone()]), new ObjectNormalizer()];
        $encoders = [new JsonEncoder()];
        $this->serialiser = new Serializer($normalisers,$encoders);
    }

    /**
     * @return SerializerInterface
     */
    public function getSerialiser(): SerializerInterface
    {
        return $this->serialiser;
    }

    /**
     * @return RequestStack
     */
    public function getStack(): RequestStack
    {
        return $this->stack;
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        if (is_null($this->request))
            $this->request = $this->getStack()->getCurrentRequest();
        return $this->request;
    }

    /**
     * hasSession
     * @return bool
     */
    private function hasSession(): bool
    {
        if ($this->getRequest() && $this->getRequest()->hasSession())
            return true;
        return false;
    }

    /**
     * @return SessionInterface|null
     */
    public function getSession(): ?SessionInterface
    {
        if (is_null($this->session) && $this->hasSession())
            $this->session = $this->getRequest()->getSession();
        return $this->session;
    }

    /**
     * @return NotificationProvider
     */
    public function getProvider(): NotificationProvider
    {
        return $this->provider;
    }

    /**
     * @return bool|string|null
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param bool|string|null $timezone
     * @return NotificationManager
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * @return Notifications|null
     */
    public function getNotifications(): ?Notifications
    {
        if (empty($this->notifications)) {
            if ($this->hasSession())
                $this->notifications = $this->getSerialiser()->deserialize($this->getSession()->get('notifications') ?: null, Notifications::class, 'json', []);
            else
                $this->notifications = new Notifications();
        }
        return $this->notifications;
    }

    /**
     * setNotifications
     * @return NotificationManager
     * @throws \Exception
     */
    public function setNotifications(): NotificationManager
    {
        $this->notifications = new Notifications();

        $this->notifications->setNotifications($this->getProvider()->findByNew());
        $first = $this->notifications->getNotifications()->first();
        $first = $first ? $first->getTimestamp() : '2000-01-01 00:00:00';
        $this->notifications->setLastNotificationTime($first);
        if ($this->hasSession())
            $this->getSession()->set('notifications', $this->getSerialiser()->serialize($this->notifications, 'json', ['attributes' => ['count', 'timezone', 'lastNotificationTime', 'notifications' => ['id', 'status','count','text','actionLink','timestamp','module'=>['id'],'person' => ['id']]]]));
        return $this;
    }

    /**
     * getCount
     * @return int
     */
    public function getCount(): int
    {
        return $this->getNotifications()->getCount();
    }

    /**
     * toArray
     * Converts the current Notifications to an Array.
     */
    public function toArray(): array
    {
        $result = [];

        foreach($this->getNotifications()->getNotifications() as $notification)
        {
            $w = $this->getSerialiser()->serialize($notification, 'json', ['attributes' => ['id','text','actionLink','timestamp','count','module' => ['name']]]);
            $result[] = json_decode($w);
        }
        return $result;
    }

    /**
     * getLastNotificationTime
     * @return \DateTime
     * @throws \Exception
     */
    public function getLastNotificationTime()
    {
        return $this->getNotifications()->getLastNotificationTime();
    }

    /**
     * archiveNotification
     * @param Notification $notification
     */
    public function archiveNotification(Notification $notification)
    {
        $this->getProvider()->archive($notification);
    }

    /**
     * archiveNotification
     * @param Notification $notification
     */
    public function deleteNotification(Notification $notification)
    {
        $this->getProvider()->delete($notification);
    }

    /**
     * getMessages
     * @return MessageManager
     */
    public function getMessages(): MessageManager
    {
        return $this->getProvider()->getMessageManager();
    }

    /**
     * deleteAllNotification
     */
    public function archiveAllNotification()
    {
        $this->getProvider()->archiveAllByUser();
    }
}