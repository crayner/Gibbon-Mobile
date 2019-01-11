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
 * Date: 5/01/2019
 * Time: 10:27
 */
namespace App\Entity;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TimetableEvent
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return TimetableEvent
     */
    public function setName(string $name): TimetableEvent
    {
        $this->name = $name;
        return $this;
    }

    /**
     * TimetableEvent constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
        $this->setId(uniqid('mob_'));
        $this->setLinks([]);
    }

    /**
     * @var \DateTime|null
     */
    private $start;

    /**
     * @var \DateTime|null
     */
    private $end;

    /**
     * @return \DateTime|null
     */
    public function getStart(): ?\DateTime
    {
        return $this->start;
    }

    /**
     * @param \DateTime|null $start
     * @return TimetableEvent
     */
    public function setStart(?\DateTime $start): TimetableEvent
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getEnd(): ?\DateTime
    {
        return $this->end;
    }

    /**
     * @param \DateTime|null $end
     * @return TimetableEvent
     */
    public function setEnd(?\DateTime $end): TimetableEvent
    {
        $this->end = $end;
        return $this;
    }

    /**
     * @var string|null
     */
    private $location = '';

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     * @return TimetableEvent
     */
    public function setLocation(?string $location): TimetableEvent
    {
        $this->location = $location ?: '';
        return $this;
    }

    /**
     * @var string|null
     */
    private $className;

    /**
     * @return string|null
     */
    public function getClassName(): ?string
    {
        return $this->className;
    }

    /**
     * @param string|null $className
     * @return TimetableEvent
     */
    public function setClassName(?string $className): TimetableEvent
    {
        $this->className = $className;
        return $this;
    }

    /**
     * @var bool
     */
    private $allDayEvent = false;

    /**
     * @return bool
     */
    public function isAllDayEvent(): bool
    {
        return $this->allDayEvent;
    }

    /**
     * @param bool $allDayEvent
     * @return TimetableEvent
     */
    public function setAllDayEvent(bool $allDayEvent = true): TimetableEvent
    {
        $this->allDayEvent = $allDayEvent;
        return $this;
    }

    /**
     * @var string
     */
    private $eventType = 'normal';

    /**
     * @return string
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     * @return TimetableEvent
     */
    public function setEventType(string $eventType): TimetableEvent
    {
        $this->eventType = $eventType;
        return $this;
    }

    /**
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return TimetableEvent
     */
    public function setId(string $id): TimetableEvent
    {
        $this->id = $id;
        return $this;
    }

    /**
     * __toArray
     * @return array
     */
    public function __toArray(): array
    {
        $event = (array) $this;
        foreach($event as $q=>$w)
        {
            unset($event[$q]);
            $event[str_replace("\x00App\Entity\TimetableEvent\x00", '',  $q)] = $w;
        }
        return $event;
    }

    /**
     * @var bool
     */
    private $schoolDay = true;

    /**
     * @return bool
     */
    public function isSchoolDay(): bool
    {
        return $this->schoolDay;
    }

    /**
     * @param bool $schoolDay
     * @return TimetableEvent
     */
    public function setSchoolDay(bool $schoolDay): TimetableEvent
    {
        $this->schoolDay = $schoolDay;
        return $this;
    }

    /**
     * @var string
     */
    private $phone = '';

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return TimetableEvent
     */
    public function setPhone(string $phone): TimetableEvent
    {
        $this->phone = $phone ?: '';
        return $this;
    }

    /**
     * @var string
     */
    private $description = '';

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return TimetableEvent
     */
    public function setDescription(string $description): TimetableEvent
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @var array
     */
    private $links;

    /**
     * @return array|bool
     */
    public function getLinks(): array
    {
        if (empty($this->links))
            $this->links = [];
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'attendance' => false,
            'external' => false,
        ]);
        $this->links = $resolver->resolve($this->links);
        return $this->links;
    }

    /**
     * @param array $links
     * @return TimetableEvent
     */
    public function setLinks(array $links): TimetableEvent
    {
        $this->links = $links;
        $this->getLinks();
        return $this;
    }

    /**
     * addLink
     * @param string $name
     * @param string $link
     * @return TimetableEvent
     */
    public function addLink(string $name, string $link): TimetableEvent
    {
        $links = $this->getLinks();
        $links[$name] = $link;
        return $this->setLinks($links);
    }

    /**
     * @var \DateTime
     */
    private $dayDate;

    /**
     * @return \DateTime
     */
    public function getDayDate(): \DateTime
    {
        return $this->dayDate;
    }

    /**
     * @param \DateTime $dayDate
     * @return TimetableEvent
     */
    public function setDayDate(\DateTime $dayDate): TimetableEvent
    {
        $this->dayDate = $dayDate;
        return $this;
    }

    /**
     * @var string
     */
    private $attendanceStatus = 'orange';

    /**
     * @return string
     */
    public function getAttendanceStatus(): string
    {
        return $this->attendanceStatus;
    }

    /**
     * @param string $attendanceStatus
     * @return TimetableEvent
     */
    public function setAttendanceStatus(bool $attendanceStatus): TimetableEvent
    {
        $this->attendanceStatus = $attendanceStatus ? 'green' : 'orange' ;
        return $this;
    }
}