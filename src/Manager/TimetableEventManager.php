<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 5/01/2019
 * Time: 10:27
 */
namespace App\Manager;


use App\Entity\TimetableEvent;
use App\Util\SchoolYearHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimetableEventManager
{
    /**
     * @var ArrayCollection
     */
    private $events;

    /**
     * getEvents
     * @return ArrayCollection
     */
    public function getEvents(): ArrayCollection
    {
        if (empty($this->events))
            $this->events = new ArrayCollection();

        return $this->events;
    }

    /**
     * setEvents
     * @param ArrayCollection|null $events
     * @return TimetableEventManager
     */
    public function setEvents(?ArrayCollection $events): TimetableEventManager
    {
        $this->events = $events;
        return $this;
    }

    /**
     * addEvent
     * @param TimetableEvent $event
     * @return TimetableEventManager
     */
    public function addEvent(TimetableEvent $event): TimetableEventManager
    {
        if ($this->getEvents()->contains($event))
            return $this;

        $this->events->add($event);

        return $this;
    }

    /**
     * @var array
     */
    private $day;

    /**
     * @return array
     */
    public function getDay(): array
    {
        return $this->day;
    }

    /**
     * @param array $day
     * @return TimetableEventManager
     */
    public function setDay(array $day): TimetableEventManager
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired([
            'date',
            'name',
            'week',
        ]);
        $resolver->setDefaults([
            'colour' => '#e4e4e4',
            'fontColour' => '#666666',
        ]);
        $day['week'] = SchoolYearHelper::getWeekNumber($day['date']);
        $resolver->setAllowedTypes('date', \DateTime::class);
        $resolver->setAllowedTypes('name', 'string');
        $resolver->setAllowedTypes('colour', 'string');
        $resolver->setAllowedTypes('fontColour', 'string');
        $resolver->setAllowedTypes('week', 'integer');

        $this->day = $resolver->resolve($day);

        if (strlen($this->day['colour']) === 6 && preg_match('/^(?:[0-9a-fA-F]{3}){1,2}$/', $this->day['colour']))
            $this->day['colour'] = '#' . $this->day['colour'];

        if (strlen($this->day['fontColour']) === 6 && preg_match('/^(?:[0-9a-fA-F]{3}){1,2}$/', $this->day['fontColour']))
            $this->day['fontColour'] = '#' . $this->day['fontColour'];

        return $this;
    }

    /**
     * @var bool
     */
    private $schoolOpen = false;

    /**
     * @return bool
     */
    public function isSchoolOpen(): bool
    {
        return $this->schoolOpen;
    }

    /**
     * @param bool $schoolOpen
     * @return TimetableEventManager
     */
    public function setSchoolOpen(bool $schoolOpen): TimetableEventManager
    {
        $this->schoolOpen = $schoolOpen;
        return $this;
    }

    /**
     * sortEvents
     * @return ArrayCollection
     */
    public function sortEvents(): ArrayCollection
    {
        $iterator = $this->getEvents()->getIterator();

        $iterator->uasort(
            function ($a, $b) {
                if (is_null($a->getStart())) $a->setAllDayEvent(true);
                if (is_null($b->getStart())) $b->setAllDayEvent(true);
                if ($a->isAllDayEvent() && !$b->isAllDayEvent()) return -1;
                if (!$a->isAllDayEvent() && $b->isAllDayEvent()) return 1;
                if ($a->isAllDayEvent() && $b->isAllDayEvent()) {
                    return $a->getEventTypePriority($b) . $a->getName() < $b->getEventTypePriority($a) . $b->getName() ? -1 : 1;
                }
                return $a->getStart()->format('Hi') . $a->getName() . $a->getEventTypePriority($b) < $b->getStart()->format('Hi') . $b->getName()  . $b->getEventTypePriority($a) ? -1 : 1;
            }
        );

       $this->setEvents(new ArrayCollection(iterator_to_array($iterator, false)));

       return $this->getEvents();
    }
}