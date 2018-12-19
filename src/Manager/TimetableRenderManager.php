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

use App\Entity\DaysOfWeek;
use App\Entity\Person;
use App\Provider\TimetableProvider;
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
     * render
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

        $blank = true;

        //Find out which timetables I am involved in this year
        $result['tt'] = $this->getTimetableProvider()->findByPersonSchoolYearActive(['person' => $person, 'schoolYear' => SchoolYearHelper::getCurrentSchoolYear(), 'active' => 'Y']);

        //If I am not involved in any timetables display all within the year
        if (empty($result))
            $result['tt'] = $this->getTimetableProvider()->findBySchoolYearActive(['schoolYear' => SchoolYearHelper::getCurrentSchoolYear(), 'active' => 'Y']);

        if (! empty($timetableID)) {
            if (SecurityHelper::isActionAccessible('/modules/Timetable/tt_master.php', 'View Master Timetable')) {
                $result['tt'] = $this->getTimetableProvider()->find($timetableID);
            } else {
                $result['tt'] = $this->getTimetableProvider()->findByPersonSchoolYearTimetable(['timetable' => $timetableID, 'person' => $person, 'schoolYear' => SchoolYearHelper::getCurrentSchoolYear()]);
            }
        }

        $days = $this->getTimetableProvider()->getRepository(DaysOfWeek::class)->findBy([],['sequenceNumber' => 'ASC']);
        $timeStart = '';
        $timeEnd = '';
        foreach ($days as $day) {
            if ($day->isSchoolDay()) {
                if ($timeStart == '' || $timeEnd == '') {
                    $timeStart = $day->getSchoolStart();
                    $timeEnd = $day->getSchoolEnd();
                } else {
                    if ($day->getSchoolStart() < $timeStart)
                        $timeStart = $day->getSchoolStart();
                    if ($day->getSchoolEnd() > $timeEnd)
                        $timeEnd = $day->getSchoolEnd();
                }
            }
            $days[$day->getNameShort()] = $day;
        }

        //move to next schoolDay
        while (! $days[$startDayStamp->format('D')]->isSchoolDay())
            $startDayStamp->add(new \DateInterval('P1D'));
        $result['date'] = $startDayStamp->format('Y-m-d');

        $result['week'] = SchoolYearHelper::getWeekNumber($startDayStamp);

        $result['render'] = true;
        return $result;
    }

    /**
     * @var TranslatorInterface
     */
    private  $translator;

    /**
     * @var TimetableProvider
     */
    private $timetableProvider;

    /**
     * TimetableRenderManager constructor.
     * @param TranslatorInterface $translator
     * @param TimetableProvider $timetableProvider
     */
    public function __construct(TranslatorInterface $translator, TimetableProvider $timetableProvider)
    {
        $this->translator = $translator;
        $this->timetableProvider = $timetableProvider;
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
}