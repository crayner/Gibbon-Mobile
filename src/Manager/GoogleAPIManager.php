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
 * Date: 30/12/2018
 * Time: 15:15
 */
namespace App\Manager;

use Symfony\Component\Security\Core\User\UserInterface;

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
     * GoogleAPIManager constructor.
     * @param UserInterface $user
     * @param SettingManager $settingManager
     */
    public function __construct(UserInterface $user, SettingManager $settingManager)
    {
        $this->settingManager = $settingManager;
        $this->user = $user;
    }

    //Returns events from a Google Calendar XML field, between the time and date specified
    function getCalendarEvents($xml, \DateTime $date)
    {
        $googleOAuth = $this->getSettingManager()->getSettingByScope('System', 'googleOAuth');

        $googleAPIAccessToken = $this->getSettingManager()->getSession()->get('googleAPIAccessToken');
        if ($googleOAuth == 'Y' and ! empty($googleAPIAccessToken)) {
            $eventsSchool = [];
            $start = $date->format('Y-m-d');
            $date->add(new \DateInterval('P1D'));
            $end = $date->format('Y-m-d');

            $client = new \Google_Client();
            $token = json_decode(json_encode($googleAPIAccessToken));
            $client->setAccessToken(json_encode($token));

            if ($client->isAccessTokenExpired()) { //Need to refresh the token
                //Get API details
                $googleClientName = $this->getSettingManager()->getSettingByScope('System', 'googleClientName');
                $googleClientID = $this->getSettingManager()->getSettingByScope('System', 'googleClientID');
                $googleClientSecret = $this->getSettingManager()->getSettingByScope('System', 'googleClientSecret');
                $googleRedirectUri = $this->getSettingManager()->getSettingByScope('System', 'googleRedirectUri');
                $googleDeveloperKey = $this->getSettingManager()->getSettingByScope('System', 'googleDeveloperKey');

                //Re-establish $client
                $client->setApplicationName($googleClientName); // Set your application name
                $client->setScopes(array(``)); // set scope during user login
                $client->setClientId($googleClientID); // paste the client id which you get from google API Console
                $client->setClientSecret($googleClientSecret); // set the client secret
                $client->setRedirectUri($googleRedirectUri); // paste the redirect URI where you given in APi Console. You will get the Access Token here during login success
                $client->setDeveloperKey($googleDeveloperKey); // Developer key
                $client->setAccessType('offline');
                if (empty($this->getUser()->getGoogleAPIRefreshToken())) {
                    $this->getSettingManager()->getMessageManager()->add('danger', 'Your request failed due to a database error.');
;                }
                else {
                    $client->refreshToken($this->getUser()->getGoogleAPIRefreshToken());
                    $this->getSettingManager()->getSession()->set('googleAPIAccessToken', $client);
                }
            }

            $getFail = false;
            $calendarListEntry = array();
            try {
                $service = new \Google_Service_Calendar($client);
                $optParams = array('timeMin' => $start.'+00:00', 'timeMax' => $end.'+00:00', 'singleEvents' => true);
                $calendarListEntry = $service->events->listEvents($xml, $optParams);
            } catch (\Exception $e) {
                dump($e);
                $getFail = true;
            }
dd($calendarListEntry,$getFail,$start,$end);
            if ($getFail) {
                $eventsSchool = false;
            } else {
                $count = 0;
                foreach ($calendarListEntry as $entry) {
                    $multiDay = false;
                    if (substr($entry['start']['dateTime'], 0, 10) != substr($entry['end']['dateTime'], 0, 10)) {
                        $multiDay = true;
                    }
                    if ($entry['start']['dateTime'] == '') {
                        if ((strtotime($entry['end']['date']) - strtotime($entry['start']['date'])) / (60 * 60 * 24) > 1) {
                            $multiDay = true;
                        }
                    }

                    if ($multiDay) { //This event spans multiple days
                        if ($entry['start']['date'] != $entry['start']['end']) {
                            $days = (strtotime($entry['end']['date']) - strtotime($entry['start']['date'])) / (60 * 60 * 24);
                        } elseif (substr($entry['start']['dateTime'], 0, 10) != substr($entry['end']['dateTime'], 0, 10)) {
                            $days = (strtotime(substr($entry['end']['dateTime'], 0, 10)) - strtotime(substr($entry['start']['dateTime'], 0, 10))) / (60 * 60 * 24);
                            ++$days; //A hack for events that span multiple days with times set
                        }
                        for ($i = 0; $i < $days; ++$i) {
                            //WHAT
                            $eventsSchool[$count][0] = $entry['summary'];

                            //WHEN - treat events that span multiple days, but have times set, the same as those without time set
                            $eventsSchool[$count][1] = 'All Day';
                            $eventsSchool[$count][2] = strtotime($entry['start']['date']) + ($i * 60 * 60 * 24);
                            $eventsSchool[$count][3] = null;

                            //WHERE
                            $eventsSchool[$count][4] = $entry['location'];

                            //LINK
                            $eventsSchool[$count][5] = $entry['htmlLink'];

                            ++$count;
                        }
                    } else {  //This event falls on a single day
                        //WHAT
                        $eventsSchool[$count][0] = $entry['summary'];

                        //WHEN
                        if ($entry['start']['dateTime'] != '') { //Part of day
                            $eventsSchool[$count][1] = 'Specified Time';
                            $eventsSchool[$count][2] = strtotime(substr($entry['start']['dateTime'], 0, 10).' '.substr($entry['start']['dateTime'], 11, 8));
                            $eventsSchool[$count][3] = strtotime(substr($entry['end']['dateTime'], 0, 10).' '.substr($entry['end']['dateTime'], 11, 8));
                        } else { //All day
                            $eventsSchool[$count][1] = 'All Day';
                            $eventsSchool[$count][2] = strtotime($entry['start']['date']);
                            $eventsSchool[$count][3] = null;
                        }
                        //WHERE
                        $eventsSchool[$count][4] = $entry['location'];

                        //LINK
                        $eventsSchool[$count][5] = $entry['htmlLink'];

                        ++$count;
                    }
                }
            }
        } else {
            $eventsSchool = false;
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


}