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
 * Date: 8/04/2019
 * Time: 13:52
 */
namespace App\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\SwitchUserEvent;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * Class SwitchUserListener
 * @package App\Security
 */
class SwitchUserListener  implements EventSubscriberInterface
{
    /**
     * getSubscribedEvents
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::SWITCH_USER => ['switchUser'],
        ];
    }

    public function switchUser(SwitchUserEvent $event)
    {
        $session = $event->getRequest()->getSession();
        if (empty($switchUser = $event->getRequest()->get('_switch_user')))
            return ;
        $session->set(
            '_locale',
            $event->getTargetUser()->getLocale()
        );
        if ($session->has('googleAPIAccessToken') && $switchUser !== '_exit') {
            $session->set('_googleAPIAccessToken', $session->get('googleAPIAccessToken'));
            $session->remove('googleAPIAccessToken');
        }
        if ($session->has('_googleAPIAccessToken') && $switchUser === '_exit') {
            $session->set('googleAPIAccessToken', $session->get('_googleAPIAccessToken'));
            $session->remove('_googleAPIAccessToken');
        }
    }
}