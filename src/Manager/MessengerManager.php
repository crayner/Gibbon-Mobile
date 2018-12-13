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
     * setMessages
     * @param string $showDate
     * @return MessengerManager
     * @throws \Exception
     */
    public function setMessages(string $showDate = 'today'): MessengerManager
    {
        $messages = new ArrayCollection();

        foreach($this->getIndividualMessages() as $message)
            if (!$messages->contains($message))
                $messages->add($message);

        foreach($this->getRoleCategoryMessages($showDate) as $message)
            if (!$messages->contains($message))
                $messages->add($message);

        foreach($this->getRoleMessages($showDate) as $message)
            if (!$messages->contains($message))
                $messages->add($message);

        foreach($this->getYearGroupMessages($showDate) as $message)
            if (!$messages->contains($message))
                $messages->add($message);

        foreach($this->getRollGroupMessages($showDate) as $message)
            if (!$messages->contains($message))
                $messages->add($message);

        dump($messages);
        trigger_error('STOP HERE', E_USER_ERROR);
        $this->messages = new ArrayCollection($messages);


     //   'Class','Course','Roll Group','Year Group','Activity','Role','Applicants','Houses','Transport','Attendance','Group'
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
        $messages =  $this->getProvider()->getYearGroupStaffMessages($showDate, $this->getTimezone()) ;

        $messages =  array_merge($messages, $this->getProvider()->getYearGroupStudentMessages($showDate, $this->getTimezone()));

        $messages =  array_merge($messages, $this->getProvider()->getYearGroupParentMessages($showDate, $this->getTimezone()));

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
        $messages =  $this->getProvider()->getRollGroupStaffMessages($showDate, $this->getTimezone()) ;

//        $messages =  array_merge($messages, $this->getProvider()->getYearGroupStudentMessages($showDate, $this->getTimezone()));

//        $messages =  array_merge($messages, $this->getProvider()->getYearGroupParentMessages($showDate, $this->getTimezone()));

        return $messages;
    }
}