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
 * Date: 8/12/2018
 * Time: 11:43
 */
namespace App\Manager;

use App\Util\UserHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class NotificationTrayManager
 * @package App\Manager
 */
class NotificationTrayManager
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @var bool
     */
    private $displayTray = false;

    /**
     * @var Request
     */
    private $stack;

    /**
     * NotificationTrayManager constructor.
     * @param TranslatorInterface $translation
     */
    public function __construct(TranslatorInterface $translator, NotificationManager $notificationManager, RequestStack $stack)
    {
        $this->translator = $translator;
        $this->notificationManager = $notificationManager;
        $this->setDisplayTray();
        $this->stack = $stack;
    }

    /**
     * getNotificationTrayProperties
     * @return array
     */
    public function getNotificationTrayProperties(): string
    {
        $result = [];

        $translations = [];
        $translations['Message Wall'] = $this->getTranslator()->trans('Message Wall', [], 'messages');
        $translations['Likes'] = $this->getTranslator()->trans('Likes', [], 'messages');
        $translations['Notifications'] = $this->getTranslator()->trans('Notifications', [], 'messages');

        $result['translations'] = $translations;

        $result['displayTray'] = $this->getDisplayTray();
        $result['locale'] = $this->getStack()->getCurrentRequest()->get('_locale');
        $result['isStaff'] = UserHelper::isStaff();

        return json_encode($result);
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @return NotificationManager
     */
    public function getNotificationManager(): NotificationManager
    {
        return $this->notificationManager;
    }

    /**
     * getDisplayTray
     * @return bool
     */
    public function getDisplayTray(): bool
    {
        return (bool) $this->displayTray;
    }

    /**
     * @param NotificationManager $displayTray
     * @return NotificationTrayManager
     */
    public function setDisplayTray(): NotificationTrayManager
    {
        $person = UserHelper::getCurrentUser();
        if ($person instanceof UserInterface)
            $this->displayTray = true;
        return $this;
    }

    /**
     * getStack
     * @return RequestStack
     */
    public function getStack(): RequestStack
    {
        return $this->stack;
    }
}