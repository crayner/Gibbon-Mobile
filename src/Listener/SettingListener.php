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
namespace App\Listener;

use App\Manager\SettingManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class SettingListener
 * @package App\Listener
 */
class SettingListener implements EventSubscriberInterface
{
    /**
     * @var SettingManager
     */
    private $manager;

    /**
     * SettingListener constructor.
     * @param SettingManager $manager
     */
    public function __construct(?SettingManager $manager = null)
    {
        $this->manager = $manager;
    }

    /**
     * getSubscribedEvents
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $listeners = [
            KernelEvents::RESPONSE => 'onResponse',
            KernelEvents::REQUEST => 'onRequest',
        ];

        return $listeners;
    }

    /**
     * onResponse
     */
    public function onResponse()
    {
        if ($this->manager instanceof SettingManager)
            $this->manager->saveSettingCache();
    }

    /**
     * onRequest
     */
    public function onRequest(KernelEvent $event)
    {
        $request = $event->getRequest();
        if (! $request->hasSession()) {
            $session = new Session();
            $session->start();
        }
    }
}