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
 * Time: 12:17
 */
namespace App\Manager;

use App\Entity\Person;
use App\Provider\PlannerEntryProvider;
use App\Util\UserHelper;

/**
 * Class StudentDashboardManager
 * @package App\Manager
 */
class StudentDashboardManager extends DashboardManager
{
    /**
     * getDashboardName
     * @return string
     */
    public function getDashboardName(): string
    {
        return 'Student Dashboard';
    }


    /**
     * @var array
     */
    private $lessonContent;

    /**
     * getContent
     * @return array
     */
    public function getLessonContent(): array
    {
        if (empty($this->lessonContent))
            $this->lessonContent = $this->getProvider(PlannerEntryProvider::class)->getStudentDashboardContent($this->getTimezone());
        return $this->lessonContent;
    }

    /**
     * hasTimetable
     * @return bool
     */
    public function hasTimetable(): bool
    {
        return true;
    }

    /**
     * getProperties
     * @return array
     */
    public function getProperties(): array
    {
        return $this->getTimetableProps();
    }

    /**
     * @var Person
     */
    private $person;

    /**
     * getPerson
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person = $this->person ?: UserHelper::getCurrentUser();
    }
}