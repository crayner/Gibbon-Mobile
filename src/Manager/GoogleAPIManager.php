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
 * Date: 30/12/2018
 * Time: 15:15
 */
namespace App\Manager;

use App\Security\GoogleAuthenticator;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class GoogleAPIManager
 * @package App\Manager
 */
class GoogleAPIManager
{
    /**
     * @var SettingManager 
     */
    private $settingManager;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var GoogleAuthenticator
     */
    private $authenticator;

    /**
     * GoogleAPIManager constructor.
     * @param UserInterface $user
     * @param GoogleAuthenticator $authenticator
     */
    public function __construct(UserInterface $user, GoogleAuthenticator $authenticator)
    {
        $this->settingManager = $authenticator->getSettingManager();
        $this->user = $user;
        $this->authenticator = $authenticator;
    }


    /**
     * getCalendarEvents
     *
     * Returns events from a Google Calendar XML field, between the time and date specified
     * @param $calendarId
     * @param \DateTime $date
     * @return array
     * @throws \Google_Exception
     */
    function getCalendarEvents($calendarId, \DateTime $date): array
    {
        $googleOAuth = $this->getSettingManager()->getSettingByScopeAsBoolean('System', 'googleOAuth');
        $date = clone $date;

        if ($this->getAuthenticator()->isAuthenticated()) {
            $eventsSchool = [];
            $start = $date->format('Y-m-d');
            $date = $date->add(new \DateInterval('P1D'));
            $end = $date->format('Y-m-d');
            $getFail = false;
            $calendarListEntry = array();
            try {
                $service = new \Google_Service_Calendar($this->getAuthenticator()->getClient());
                $optParams = array('timeMin' => date('c', strtotime($start.' 00:00')), 'timeMax' => date('c', strtotime($start.' 23:59')), 'singleEvents' => true, 'orderBy' => 'startTime');
                $calendarListEntry = $service->events->listEvents($calendarId, $optParams);
            } catch (\Google_Service_Exception $e) {
                $getFail = true;
            }

            if ($getFail) {
                $eventsSchool = false;
            } else {
                $count = 0;
                foreach ($calendarListEntry->getItems() as $entry) {
                    $eventsSchool[$count]['id'] = $entry->getId();
                    $multiDay = false;
                    if (substr($entry->start->dateTime, 0, 10) != substr($entry->end->dateTime, 0, 10)) {
                        $multiDay = true;
                    }
                    if ($entry->start->dateTime == '') {
                        if ((strtotime($entry->end->date) - strtotime($entry->start->date)) / (86400) > 1) {
                            $multiDay = true;
                        }
                    }
                    if ($multiDay) { //This event spans multiple days
                        if ($entry->end->date != $entry->start->date) {
                            $days = (strtotime($entry->end->date) - strtotime($entry->start->date)) / (86400);
                        } elseif (substr($entry->start->dateTime, 0, 10) != substr($entry->end->dateTime, 0, 10)) {
                            $days = (strtotime(substr($entry->end->dateTime, 0, 10)) - strtotime(substr($entry->start->dateTime, 0, 10))) / (86400);
                            ++$days; //A hack for events that span multiple days with times set
                        }
                        //WHAT
                        $eventsSchool[$count]['summary'] = $entry->getSummary();

                        //WHEN - treat events that span multiple days, but have times set, the same as those without time set
                        $eventsSchool[$count]['eventType'] = 'All Day';
                        $eventStart = $entry->start->dateTime ?: $entry->start->date;
                        $eventEnd = $entry->end->dateTime ?: $entry->end->date;
                        if (strtotime($eventStart) < strtotime($start)) {
                            $eventsSchool[$count]['start'] = date('c', strtotime($start));
                            $eventsSchool[$count]['eventType'] = 'Specified Time';
                        } else {
                            $eventsSchool[$count]['start'] = $eventStart;
                        }
                        if (strtotime($eventEnd) >= strtotime($end)) {
                            $eventsSchool[$count]['end'] = date('c', strtotime($end));
                            $eventsSchool[$count]['eventType'] = 'Specified Time';
                        } else {
                            $eventsSchool[$count]['end'] = $eventEnd;
                        }
                        $end = new \DateTime($eventsSchool[$count]['end']);
                        $eventLength = $end->diff(new \DateTime($eventsSchool[$count]['start']));
                        if ($eventLength->days >= 1)
                            $eventsSchool[$count]['eventType'] = 'All Day';

                        //WHERE
                        $eventsSchool[$count]['location'] = $entry->getLocation();

                        //LINK
                        $eventsSchool[$count]['link'] = $entry->getHtmlLink();

                        ++$count;
                    } else {  //This event falls on a single day
                        //WHAT
                        $eventsSchool[$count]['summary'] = $entry->getSummary();
                        //WHEN
                        $eventStart = $entry->start->dateTime ?: $entry->start->date;
                        $eventEnd = $entry->end->dateTime ?: $entry->end->date;
                        $eventsSchool[$count]['eventType'] = 'All Day';
                        if ($entry['start']['dateTime'] != '') { //Part of day
                            $eventsSchool[$count]['eventType'] = 'Specified Time';
                        }
                        $eventsSchool[$count]['start'] = $eventStart;
                        $eventsSchool[$count]['end'] = $eventEnd;
                        //WHERE
                        $eventsSchool[$count]['location'] = $entry->getLocation();

                        //LINK
                        $eventsSchool[$count]['link'] = $entry->getHtmlLink();

                        ++$count;
                    }
                }
            }
        } else {
            $eventsSchool = [];
        }

        return $eventsSchool;
    }

    /**
     * @return SettingManager
     */
    public function getSettingManager(): SettingManager
    {
        return $this->settingManager;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @return GoogleAuthenticator
     */
    public function getAuthenticator(): GoogleAuthenticator
    {
        return $this->authenticator;
    }


}