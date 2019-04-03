<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 9/12/2018
 * Time: 08:53
 */

namespace App\Manager\Objects;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Notifications
 * @package App\Manager\Objects
 */
class Notifications
{
    /**
     * @var int
     */
    private $count = 0;

    /**
     * @var \DateTime|null
     */
    private $lastNotificationTime;

    /**
     * @var ArrayCollection
     */
    private $notifications;

    /**
     * @var string
     */
    private $timezone = 'UTC';

    /**
     * getCount
     * @param bool $refresh
     * @return int|null
     */
    public function getCount(bool $refresh = false): ?int
    {
        return $this->count = (empty($this->count) || $refresh) ? $this->getNotifications()->count() : $this->count;
    }

    /**
     * @param int $count
     * @return Notifications
     */
    public function setCount(int $count): Notifications
    {
        $this->count = intval($count);
        return $this;
    }

    /**
     * getLastNotificationTime
     * @param bool $refresh
     * @return \DateTime
     * @throws \Exception
     */
    public function getLastNotificationTime(bool $refresh = false): \DateTime
    {
        if (empty($this->lastNotificationTime) || $refresh)
        {
            $first = $this->getNotifications()->first();
            $first = $first ? $first->getTimestamp() : '2000-01-01 00:00:00';
            $this->setLastNotificationTime($first);
        }
        return $this->lastNotificationTime;
    }

    /**
     * setLastNotificationTime
     * @param string|\DateTime|null $lastNotificationTime
     * @return Notifications
     * @throws \Exception
     */
    public function setLastNotificationTime($lastNotificationTime): Notifications
    {
        $this->lastNotificationTime = is_string($lastNotificationTime) ? new \DateTime($lastNotificationTime) : ($lastNotificationTime instanceof \DateTime ? $lastNotificationTime : new \DateTime('2000-01-01 00:00:00', new \DateTimeZone($this->getTimezone())));

        return $this;
    }

    /**
     * getNotifications
     * @return ArrayCollection
     */
    public function getNotifications(): ArrayCollection
    {
        if (empty($this->notifications) || ! $this->notifications instanceof ArrayCollection)
            $this->notifications = new ArrayCollection();
        return $this->notifications;
    }

    /**
     * setNotifications
     * @param array|ArrayCollection|null $notifications
     * @return Notifications
     */
    public function setNotifications($notifications): Notifications
    {
        $this->notifications = is_array($notifications) ? new ArrayCollection($notifications) : ($notifications instanceof ArrayCollection ? $notifications : new ArrayCollection());
        $this->getCount(true);
        $this->getLastNotificationTime(true);
        return $this;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     * @return Notifications
     */
    public function setTimezone(string $timezone): Notifications
    {
        $this->timezone = $timezone;
        return $this;
    }
}