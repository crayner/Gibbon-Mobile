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
 * Time: 08:35
 */
namespace App\Provider;

use App\Entity\Notification;
use App\Entity\Person;
use App\Manager\Traits\EntityTrait;
use App\Util\UserHelper;

/**
 * Class NotificationProvider
 * @package App\Provider
 */
class NotificationProvider
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Notification::class;

    /**
     * findByNew
     * @param Person|null $person
     * @return object[]
     * @throws \Exception
     */
    public function findByNew(?Person $person = null): array
    {
        $person = $person ?: UserHelper::getCurrentUser();
        return $this->getRepository()->findBy(['status' => 'New', 'person' => $person], ['timestamp' => 'ASC']) ?: [];
    }

    /**
     * archive
     * @param Notification $notification
     * @param bool $flush
     */
    public function archive(Notification $notification, bool $flush = true)
    {
        $this->setEntity($notification);
        $this->getEntity()->setStatus('Archived');
        $this->saveEntity(null,$flush);
        if ($this->getMessageManager()->getStatus() === 'default')
            $this->getMessageManager()->add('success', 'Your request was completed successfully.', [], 'messages');
    }

    /**
     * archiveAllByUser
     * @param Person|null $person
     * @throws \Exception
     */
    public function archiveAllByUser(?Person $person = null)
    {
        $person = $person ?: UserHelper::getCurrentUser();

        foreach($this->findByNew($person) as $notification)
        {
            $this->archive($notification);
        }
        $this->flush();
    }
}