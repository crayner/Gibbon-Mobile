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
use App\Entity\SchoolYearSpecialDay;
use App\Entity\TTColumnRow;
use App\Entity\TTDay;
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
            $result['timeStart'] = '';
            $result['timeEnd'] = '';
            foreach ($days as $day) {
                if ($day->isSchoolDay()) {
                    if ($result['timeStart'] == '' || $result['timeEnd'] == '') {
                        $result['timeStart'] = $day->getSchoolStart();
                        $result['timeEnd'] = $day->getSchoolEnd();
                    } else {
                        if ($day->getSchoolStart() < $result['timeStart'])
                            $result['timeStart'] = $day->getSchoolStart();
                        if ($day->getSchoolEnd() > $result['timeEnd'])
                            $result['timeEnd'] = $day->getSchoolEnd();
                    }
                }
            }

            //move to next schoolDay
            while (!$days[$startDayStamp->format('D')]->isSchoolDay())
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

            $diff = $result['timeEnd']->diff($result['timeStart']);
            $result['timeDiff'] = $diff->format('%a') * 1440 + $diff->format('%h') * 60 + $diff->format('%i');

            $result['tt'] = $this->getTimetableProvider()->findAsArray($result['tt']);
            $result['specialDay'] = $this->getTimetableProvider()->findAsArray($result['specialDay']);
            $result['person'] = $this->getTimetableProvider()->findAsArray($result['person']);
            $result['schoolYear'] = SchoolYearHelper::getSchoolYearAsArray();
        }

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

    /**
     * renderDay
     * @param array $result
     */
    public function renderDay(array $result): array
    {
        if (! $result['schoolOpen'])
            return $result;
        $result['day'] = $this->getTimetableProvider()->getRepository(TTDay::class)->findByDateTT($result['date'], $result['tt']);

        foreach($result['day']->getTTColumn()->getTimetableColumnRows() as $row)
        {
            if ($row->getTimeStart()->format('His') < $result['timeStart']->format('His'))
                $result['timeStart'] = clone $row->getTimeStart();
            if ($row->getTimeEnd()->format('His') > $result['timeEnd']->format('His'))
                $result['timeEnd'] = clone $row->getTimeEnd();
        }



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
     * @var array|null
     */
    private $daysOfWeek;

    /**
     * getDaysOFWeek
     * @return array
     * @throws \Exception
     */
    private function getDaysOfWeek(): array
    {
        if (! empty($this->daysOfWeek))
            return $this->daysOfWeek;
        $x = $this->getTimetableProvider()->getRepository(DaysOfWeek::class)->findBy([],['sequenceNumber' => 'ASC']);
        foreach($x as $day)
            $this->daysOfWeek[$day->getNameShort()] = $day;
        return $this->daysOfWeek;
    }
}