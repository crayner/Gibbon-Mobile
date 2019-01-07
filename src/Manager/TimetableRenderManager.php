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
 * Date: 19/12/2018
 * Time: 12:13
 */
namespace App\Manager;

use App\Entity\Person;
use App\Entity\SchoolYearSpecialDay;
use App\Entity\TimetableEvent;
use App\Entity\TTColumnRow;
use App\Entity\TTDay;
use App\Entity\TTSpaceBooking;
use App\Provider\TimetableProvider;
use App\Security\GoogleAuthenticator;
use App\Util\SchoolYearHelper;
use App\Util\SecurityHelper;
use App\Util\UserHelper;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class TimetableRenderManager
 * @package App\Manager
 */
class TimetableRenderManager
{
    /**
     * @var TimetableEventManager
     */
    private $events;

    /**
     * render
     * @param Person $person
     * @param \DateTime $startDayStamp
     * @param int|null $timetableID
     * @return mixed
     * @throws \Exception
     */
    public function render(Person $person, \DateTime $startDayStamp, ?int $timetableID = null)
    {
        $highestAction = SecurityHelper::getHighestGroupedAction('/modules/Timetable/tt.php');

        $proceed = false;

        if ($highestAction == 'View Timetable by Person_allYears')
            $proceed = true;
        if ($highestAction == 'View Timetable by Person')
            $proceed = true;
        else if ($highestAction == 'View Timetable by Person_my') {
            if ($person->isEqualTo(UserHelper::getCurrentUser()))
                $proceed = true;
        } else if ($highestAction == 'View Timetable by Person_myChildren') {
            if (UserHelper::isParent($person)) {
                $children = UserHelper::getChildrenOfParent($person);
                if (count($children) > 0)
                    $proceed = true;
            }
        }

        if (! $proceed)
            $result['error'] = $this->getTranslator()->trans('You do not have permission to access this timetable at this time.');
        else {
            $result['person'] = $person;
            $blank = true;

            //Find out which timetables I am involved in this year
            $result['tt'] = $this->getTimetableProvider()->findByPersonSchoolYearActive(['person' => $person, 'schoolYear' => SchoolYearHelper::getCurrentSchoolYear(), 'active' => 'Y']);

            //If I am not involved in any timetables display all within the year
            if (empty($result['tt']))
                $result['tt'] = $this->getTimetableProvider()->findBySchoolYearActive(['schoolYear' => SchoolYearHelper::getCurrentSchoolYear(), 'active' => 'Y']);

            if (!empty($timetableID)) {
                if (SecurityHelper::isActionAccessible('/modules/Timetable/tt_master.php', 'View Master Timetable')) {
                    $result['tt'] = $this->getTimetableProvider()->find($timetableID);
                } else {
                    $result['tt'] = $this->getTimetableProvider()->findByPersonSchoolYearTimetable(['timetable' => $timetableID, 'person' => $person, 'schoolYear' => SchoolYearHelper::getCurrentSchoolYear()]);
                }
            }

            if (is_array($result['tt']))
                $result['tt'] = reset($result['tt']);
            $days = $this->getDaysOfWeek();

            //move to next schoolDay
            while ($days[$startDayStamp->format('D')]['schoolDay'] === 'N')
                $startDayStamp->add(new \DateInterval('P1D'));
            $result['date'] = clone $startDayStamp;

            $result['week'] = SchoolYearHelper::getWeekNumber($result['date']);
            $result['schoolOpen'] = true;

            $result['specialDay'] = $this->getTimetableProvider()->getRepository(SchoolYearSpecialDay::class)->findOneBy(['date' => $result['date']]);
            if (SchoolYearHelper::isDayInTerm($startDayStamp)) {
                if ($result['specialDay'] instanceof SchoolYearSpecialDay) {
                    if ($result['specialDay']->getType() === 'School Closure') {
                        $result['schoolOpen'] = false;
                        $result = $this->renderDay($result);
                    } elseif ($result['specialDay']->getType() === 'Timing Change') {
                        $result = $this->renderDay($result);
                    }
                } else {
                    $result = $this->renderDay($result);
                }
            } else {
                $result['schoolOpen'] = false;
                $result = $this->renderDay($result);
            }

            $result['render'] = $proceed;

            $this->convertLessonsToEvents($result);

            $googleAvailable = $this->getSettingManager()->getSettingByScopeAsBoolean('System', 'googleOAuth', false);
            $schoolAvailable = $this->getSettingManager()->getSettingByScopeAsString('System', 'calendarFeed', false);
            $personalAvailable = $person->getCalendarFeedPersonal() ?: false;
            $result['allowSchoolCalendar'] = $result['person']->getViewCalendarSchool($googleAvailable, $schoolAvailable) === 'Y' ? true : false ;
            $result['allowPersonalCalendar'] = $result['person']->getViewCalendarPersonal($googleAvailable) === 'Y' ? true : false ;
            $result['allowSpaceBookingCalendar'] = ($result['person']->getViewCalendarSpaceBooking() === 'Y' ? true : false) && SecurityHelper::isActionAccessible('/modules/Timetable/spaceBooking_manage.php') ;

            $googleManager = new GoogleAPIManager($person, $this->getGoogleAuthenticator());
            $this->convertGoogleCalendarEvents($result['allowSchoolCalendar'] ? $googleManager->getCalendarEvents($schoolAvailable, $result['date']) : [], 'school');
            $this->convertGoogleCalendarEvents($result['allowPersonalCalendar'] ? $googleManager->getCalendarEvents($personalAvailable, $result['date']) : [], 'personal');
            $this->convertSpaceBookingEvents($result['allowSpaceBookingCalendar'] ? $this->getSpaceBookingEvents($result['date'], $person) : [] );

        }

        return $this->getEventsAsArray();
    }

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var TimetableProvider
     */
    private $timetableProvider;

    /**
     * @var SettingManager
     */
    private $settingManager;

    /**
     * @var GoogleAuthenticator
     */
    private $googleAuthenticator;

    /**
     * TimetableRenderManager constructor.
     * @param TranslatorInterface $translator
     * @param TimetableProvider $timetableProvider
     * @param GoogleAuthenticator $googleAuthenticator
     */
    public function __construct(TranslatorInterface $translator, TimetableProvider $timetableProvider, GoogleAuthenticator $googleAuthenticator)
    {
        $this->translator = $translator;
        $this->timetableProvider = $timetableProvider;
        $this->settingManager = $googleAuthenticator->getSettingManager();
        $this->googleAuthenticator = $googleAuthenticator;
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @return TimetableProvider
     */
    public function getTimetableProvider(): TimetableProvider
    {
        return $this->timetableProvider;
    }

    /**
     * renderDay
     * @param array $result
     */
    public function renderDay(array $result): array
    {
        if (! $result['schoolOpen'])
            return $result;
        $result['day'] = $this->getTimetableProvider()->getRepository(TTDay::class)->findByDateTT($result['date'], $result['tt']);



        $day = $result['day'];
        $result['day'] = $this->getTimetableProvider()->findAsArray($result['day']);
        $result['day']['TTColumn'] = $this->getTimetableProvider()->findAsArray($day->getTTColumn());
        foreach($day->getTTColumn()->getTimetableColumnRows() as $row)
                        $result['day']['TTColumn']['timetableColumnRows'][$row->getId()] = $this->getTimetableProvider()->findAsArray($row);

        foreach($this->getTimetableProvider()->getRepository(TTColumnRow::class)->findPersonPeriods($day, $result['person'], true) as $row)
            $result['day']['TTColumn']['timetableColumnRows'][$row['id']] = $row;

        return $result;
    }

    /**
     * manageDateChange
     * @param string $date
     * @return string
     */
    public function manageDateChange(string $date): string
    {
        if ($date === 'undefined')
            return 'today';
        if (strpos($date, 'prev-') === 0)
        {
            $days = $this->getDaysOFWeek();
            $date = new \DateTime(substr($date, 5));
            $date->sub(new \DateInterval('P1D'));
            //move to next schoolDay
            while (! $days[$date->format('D')]->isSchoolDay())
                $date->sub(new \DateInterval('P1D'));
            return $date->format('Y-m-d');
        }
        if (strpos($date, 'next-') === 0)
        {
            $days = $this->getDaysOFWeek();
            $date = new \DateTime(substr($date, 5));
            $date->add(new \DateInterval('P1D'));
            //move to next schoolDay
            while (! $days[$date->format('D')]->isSchoolDay())
                $date->add(new \DateInterval('P1D'));
            return $date->format('Y-m-d');
        }
        return $date;
    }

    /**
     * getDaysOFWeek
     * @return array
     * @throws \Exception
     */
    private function getDaysOfWeek(): array
    {
        return SchoolYearHelper::getDaysOfWeek();
    }

    /**
     * @return SettingManager
     */
    public function getSettingManager(): SettingManager
    {
        return $this->settingManager;
    }

    /**
     * @return GoogleAuthenticator
     */
    public function getGoogleAuthenticator(): GoogleAuthenticator
    {
        return $this->googleAuthenticator;
    }

    /**
     * getSpaceBookingEvents
     * @param \DateTime $date
     * @param Person|null $person
     * @return array|bool
     * @throws \Exception
     */
    function getSpaceBookingEvents(\DateTime $date, ?Person $person = null): array
    {
        $resultSpaceBooking = $this->getTimetableProvider()->getRepository(TTSpaceBooking::class)->findByDatePerson($date, $person);
        $return = [];

        if (count($resultSpaceBooking) > 0) {
            $return = [];
            foreach($resultSpaceBooking as $rowSpaceBooking) {
                $result = [];
                $result['id'] = $rowSpaceBooking->getId();
                $result['name'] = $rowSpaceBooking->getName();
                $result['person'] = $rowSpaceBooking->getPerson() ? $rowSpaceBooking->getPerson()->getId() : null;
                $result['date'] = $rowSpaceBooking->getDate();
                $result['timeStart'] = $rowSpaceBooking->getTimeStart();
                $result['timeEnd'] = $rowSpaceBooking->getTimeEnd();
                $result['personName'] = $rowSpaceBooking->getPerson() ? $rowSpaceBooking->getPerson() ->formatName() : '';
                $return[] = $result;
            }
        }

        return $return;
    }

    /**
     * @return TimetableEventManager
     */
    private function getEvents(): TimetableEventManager
    {
        if (empty($this->events))
            $this->events = new TimetableEventManager();
        return $this->events;
    }

    /**\
     * convertLessonsToEvents
     * @param array $result
     * @return TimetableRenderManager
     */
    private function convertLessonsToEvents(array $result): TimetableRenderManager
    {
        $this->getEvents();
        $day['date'] = $result['date'];
        $day['name'] = $result['date']->format('D');
        if (isset($result['day']))
        {
            $day['name'] = $result['day']['nameShort'];
            $day['colour'] =  $result['day']['colour'];
            $day['fontColour'] =  $result['day']['fontColour'];
        }
        $this->getEvents()->setSchoolOpen(true);
        $this->getEvents()->setDay($day);
        if (!$result['schoolOpen'] && $result['specialDay'])
        {
            $event = new TimetableEvent($result['specialDay']->getName());
            $this->getEvents()->setSchoolOpen(false);
            $event->setSchoolDay(false);
            $this->getEvents()->addEvent($event);
        }
        elseif (!$result['schoolOpen'])
        {
            $event = new TimetableEvent('School Closed');
            $this->getEvents()->setSchoolOpen(false);
            $event->setAllDayEvent();
            $event->setSchoolDay(false);
            $this->getEvents()->addEvent($event);
        }
        else
        {
            foreach($result['day']['TTColumn']['timetableColumnRows'] as $row)
            {
                if (isset($row['TTDayRowClasses']))
                {
                    $event = new TimetableEvent($row['name']);
                    $class = $row['TTDayRowClasses'][0];
                    $event->setStart($row['timeStart'])
                        ->setEnd($row['timeEnd'])
                        ->setLocation($class['space']['name'])
                        ->setPhone($class['space']['phoneInt'])
                        ->setClassName($class['courseClass']['course']['nameShort'].'.'.$class['courseClass']['nameShort']);
                    $event->setId('class_' . $class['id']);
                    $this->getEvents()->addEvent($event);
                }
            }
        }

        return $this;
    }

    /**
     * convertGoogleCalendarEvents
     * @param array $events
     * @param string $eventType
     * @throws \Exception
     */
    private function convertGoogleCalendarEvents(array $events, string $eventType)
    {
        if (empty($events))
            return ;
        foreach($events as $event)
        {
            $entity = new TimetableEvent($event['summary']);
            $entity->setId($eventType.'_'.$event['id'])
                ->setLocation($event['location'])
                ->setLink($event['link'])
                ->setEventType($eventType);
            if ($event['eventType'] !== 'Specified Time') {
                $entity->setAllDayEvent();
            } else {
                $entity->setStart(new \DateTime($event['start']))
                    ->setEnd(new \DateTime($event['end']));
            }
            $this->getEvents()->addEvent($entity);
        }
    }

    /**
     * convertSpaceBookingEvents
     * @param $events
     */
    private function convertSpaceBookingEvents(array $events)
    {
        if (empty($events))
            return ;
        foreach($events as $event)
        {
            $entity = new TimetableEvent($event['personName']);
            $entity->setId('space_' . $event['id'])
                ->setLocation($event['name'])
                ->setEventType('booking')
                ->setStart($event['timeStart'])
                ->setEnd($event['timeEnd']);
            $this->getEvents()->addEvent($entity);
        }
    }

    /**
     * getEventsAsArray
     * @return array
     */
    private function getEventsAsArray(): array
    {
        $this->getEvents()->sortEvents();

        $events = [];
        $events['schoolOpen'] = $this->getEvents()->isSchoolOpen();
        $events['day'] = $this->getEvents()->getDay();
        $events['events'] = [];
        foreach($this->getEvents()->getEvents() as $event)
        {
            $events['events'][] = $event->__toArray();
        }
        $events['valid'] = true;
        return $events;
    }
}