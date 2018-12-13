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
 * Date: 12/12/2018
 * Time: 10:34
 */
namespace App\Manager;

use App\Provider\MessengerProvider;
use App\Util\UserHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class MessengerManager
 * @package App\Manager
 */
class MessengerManager
{
    /**
     * @var MessengerProvider
     */
    private $provider;

    /**
     * @var bool|string|null
     */
    private $timezone = 'UTC';

    /**
     * MessengerManager constructor.
     * @param MessengerProvider $provider
     */
    public function __construct(MessengerProvider $provider, SettingManager $settingManager)
    {
        $this->provider = $provider;
        $this->setTimezone($settingManager->getSettingByScopeAsString('System', 'timezone'));
    }

    /**
     * @var ArrayCollection
     */
    private $messages;

    /**
     * @return ArrayCollection
     */
    public function getMessages(): ArrayCollection
    {
        if (empty($this->messages))
            $this->messages = new ArrayCollection();

        return $this->messages;
    }

    /**
     * @var array
     */
    private $messagesByType;

    /**
     * @var bool
     */
    private $staff;

    /**
     * @var bool
     */
    private $student;

    /**
     * @var bool
     */
    private $parent;

    /**
     * setMessages
     * @param string $showDate
     * @return MessengerManager
     * @throws \Exception
     */
    public function setMessages(string $showDate = 'today'): MessengerManager
    {
        $messages = new ArrayCollection();

        $this->messagesByType = $this->getProvider()->getMessagesByType($showDate,$this->getTimezone());

        if ($this->hasMessagesByType('Individuals'))
            foreach($this->getIndividualMessages() as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        if ($this->hasMessagesByType('Role Categories'))
            foreach($this->getRoleCategoryMessages($showDate) as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        if ($this->hasMessagesByType('Role'))
            foreach($this->getRoleMessages($showDate) as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        if ($this->hasMessagesByType('Year Group'))
            foreach($this->getYearGroupMessages($showDate) as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        if ($this->hasMessagesByType('Roll Group'))
            foreach($this->getRollGroupMessages($showDate) as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        if ($this->hasMessagesByType('Course'))
            foreach($this->getCourseMessages($showDate) as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        if ($this->hasMessagesByType('Course Class'))
            foreach($this->getCourseClassMessages($showDate) as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        if ($this->hasMessagesByType('Activity'))
            foreach($this->getActivityMessages($showDate) as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        // Applicants are ignored..  Only Email...

        if ($this->hasMessagesByType('Houses'))
            foreach($this->getHouseMessages($showDate) as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        if ($this->hasMessagesByType('Attendance'))
            foreach($this->getAttendanceMessages($showDate) as $message)
                if (!$messages->contains($message))
                    $messages->add($message);

        dump($messages);
        trigger_error('STOP HERE', E_USER_ERROR);
        $this->messages = new ArrayCollection($messages);


//      'Transport','Attendance','Group'
        return $this;
    }

    /**
     * getCount
     * @return int
     */
    public function getCount(): int
    {
        return $this->getMessages()->count();
    }

    public function toArray()
    {
        $normalisers = [new DateTimeNormalizer(['datetime_timezone' => $this->getTimezone()]),new ObjectNormalizer()];
        $encoders = [new JsonEncoder()];
        $serialiser = new Serializer($normalisers,$encoders);
        $result = [];

        foreach($this->getMessages() as $message)
        {
            $w = $serialiser->serialize($message, 'json', ['attributes' => ['subject','body', 'person' => ['']]]);
            $result[] = json_decode($w);
        }
        return $result;
    }

    /**
     * @return bool|string|null
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param bool|string|null $timezone
     * @return MessengerManager
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * getRollGroupMessages
     * @param string $showDate
     * @return mixed
     */
    public function getRoleCategoryMessages(string $showDate = 'today')
    {
        return $this->getProvider()->getRoleCategoryMessages($showDate, $this->getTimezone()) ;
    }

    /**
     * @return MessengerProvider
     */
    public function getProvider(): MessengerProvider
    {
        return $this->provider;
    }

    /**
     * getIndividualMessages
     * @param string $showDate
     * @return array
     * @throws \Exception
     */
    public function getIndividualMessages(string $showDate = 'today')
    {
        return $this->getProvider()->getIndividualMessages($showDate, $this->getTimezone()) ;
    }

    /**
     * getRoleMessages
     * @param string $showDate
     * @return mixed
     */
    public function getRoleMessages(string $showDate = 'today')
    {
        return $this->getProvider()->getRoleMessages($showDate, $this->getTimezone()) ;
    }

    /**
     * getYearGroupMessages
     * @param string $showDate
     * @return mixed
     */
    public function getYearGroupMessages(string $showDate = 'today')
    {
        $messages =  $this->isStaff() ? $this->getProvider()->getYearGroupStaffMessages($showDate, $this->getTimezone()) : [];

        $messages =  array_merge($messages, $this->isStudent() ? $this->getProvider()->getYearGroupStudentMessages($showDate, $this->getTimezone()): []);

        $messages =  array_merge($messages, $this->isParent() ? $this->getProvider()->getYearGroupParentMessages($showDate, $this->getTimezone()) : []);

        return $messages;
    }

    /**
     * getRollGroupMessages
     * @param string $showDate
     * @return array
     * @throws \Exception
     */
    public function getRollGroupMessages(string $showDate = 'today')
    {
        $messages =   $this->isStaff() ? $this->getProvider()->getRollGroupStaffMessages($showDate, $this->getTimezone()) : [] ;

        $messages =  array_merge($messages, $this->isStudent() ? $this->getProvider()->getRollGroupStudentMessages($showDate, $this->getTimezone()) : [] );

        $messages =  array_merge($messages, $this->isParent() ? $this->getProvider()->getRollGroupParentMessages($showDate, $this->getTimezone()) : [] );

        return $messages;
    }

    /**
     * getCourseMessages
     * @param string $showDate
     * @return array
     * @throws \Exception
     */
    public function getCourseMessages(string $showDate = 'today')
    {
        $messages =  $this->getProvider()->getCourseStaffMessages($showDate, $this->getTimezone()) ;

        $messages =  array_merge($messages, $this->isStudent() ? $this->getProvider()->getCourseStudentMessages($showDate, $this->getTimezone()) : [] );

        $messages =  array_merge($messages, $this->isParent() ? $this->getProvider()->getCourseParentMessages($showDate, $this->getTimezone()) : [] );

        return $messages;
    }

    /**
     * getCourseClassMessages
     * @param string $showDate
     * @return array
     * @throws \Exception
     */
    public function getCourseClassMessages(string $showDate = 'today')
    {
        $messages =   $this->isStaff() ? $this->getProvider()->getCourseClassStaffMessages($showDate, $this->getTimezone()) : [] ;

        $messages =  array_merge($messages, $this->isStudent() ? $this->getProvider()->getCourseClassStudentMessages($showDate, $this->getTimezone()) : [] );

        $messages =  array_merge($messages, $this->isParent() ? $this->getProvider()->getCourseClassParentMessages($showDate, $this->getTimezone()) : [] );

        return $messages;
    }

    /**
     * getActivityMessages
     * @param string $showDate
     * @return array
     * @throws \Exception
     */
    public function getActivityMessages(string $showDate = 'today')
    {
        $messages =   $this->isStaff() ? $this->getProvider()->getActivityStaffMessages($showDate, $this->getTimezone()) : [] ;

        $messages =  array_merge($messages, $this->isStudent() ? $this->getProvider()->getActivityStudentMessages($showDate, $this->getTimezone()) : [] );

        $messages =  array_merge($messages, $this->isParent() ? $this->getProvider()->getActivityParentMessages($showDate, $this->getTimezone()) : [] );

        return $messages;
    }

    /**
     * hasMessagesByType
     * @param string $type
     * @return bool
     */
    private function hasMessagesByType(string $type): bool
    {
        if (empty($this->messagesByType[$type]))
            return false;
        return true;
    }

    /**
     * getActivityMessages
     * @param string $showDate
     * @return array
     * @throws \Exception
     */
    public function getHouseMessages(string $showDate = 'today')
    {
        $messages =  $this->getProvider()->getHouseMessages($showDate, $this->getTimezone()) ;
        return $messages;
    }

    /**
     * getAttendanceMessages
     * @param string $showDate
     * @return array
     */
    public function getAttendanceMessages(string $showDate = 'today')
    {
        $messages =  $this->isStudent() ? $this->getProvider()->getAttendanceStudentMessages($showDate, $this->getTimezone()) : [] ;

        $messages =  array_merge($messages, $this->isParent() ? $this->getProvider()->getAttendanceParentMessages($showDate, $this->getTimezone()) : [] );

        return $messages;
    }

    /**
     * @return array
     */
    public function getMessagesByType(): array
    {
        return $this->messagesByType;
    }

    /**
     * @return bool
     */
    public function isStaff(): bool
    {
        if (is_null($this->staff)) {
            UserHelper::getCurrentUser();
            $this->staff = UserHelper::getProvider()->isStaff();
        }return $this->staff;
    }

    /**
     * @return bool
     */
    public function isStudent(): bool
    {
        if (is_null($this->student)) {
            UserHelper::getCurrentUser();
            $this->student = UserHelper::getProvider()->isStudent();
        }
        return $this->student;
    }

    /**
     * @return bool
     */
    public function isParent(): bool
    {
        if (is_null($this->parent)) {
            UserHelper::getCurrentUser();
            $this->parent = UserHelper::getProvider()->isParent();
        }return $this->parent;
    }
}