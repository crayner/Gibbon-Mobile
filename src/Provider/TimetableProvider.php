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
 * Time: 16:40
 */
namespace App\Provider;

use App\Entity\TT;
use App\Manager\EntityProviderInterface;
use App\Manager\Traits\EntityTrait;

/**
 * Class TimetableProvider
 * @package App\Provider
 */
class TimetableProvider implements EntityProviderInterface
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = TT::class;

    /**
     * findByPersonSchoolYear
     * @param array $criteria
     * @return array
     * @throws \Exception
     */
    public function findByPersonSchoolYearActive(array $criteria): array
    {
        return $this->getRepository()->createQueryBuilder('t', 't.id')
            ->select('DISTINCT t')
            ->join('t.TTDays', 'td')
            ->join('td.TTDayRowClasses', 'tdrc')
            ->join('tdrc.courseClass', 'cc')
            ->join('cc.courseClassPeople', 'ccp')
            ->where('ccp.person = :person')
            ->andWhere('t.schoolYear = :schoolYear')
            ->andWhere('t.active = :active')
            ->setParameters($criteria)
            ->getQuery()
            ->getResult();
    }

    /**
     * findByPersonSchoolYear
     * @param array $criteria
     * @return array
     * @throws \Exception
     */
    public function findBySchoolYearActive(array $criteria): array
    {
        return $this->getRepository()->createQueryBuilder('t', 't.id')
            ->select('DISTINCT t')
            ->where('t.schoolYear = :schoolYear')
            ->andWhere('t.active = :active')
            ->setParameters($criteria)
            ->getQuery()
            ->getResult();
    }

    /**
     * findByPersonSchoolYearTimetable
     * @param array $criteria
     * @return array
     * @throws \Exception
     */
    public function findByPersonSchoolYearTimetable(array $criteria): array
    {
        return $this->getRepository()->createQueryBuilder('t', 't.id')
            ->select('DISTINCT t')
            ->join('t.TTDays', 'td')
            ->join('td.TTDayRowClasses', 'tdrc')
            ->join('tdrc.courseClass', 'cc')
            ->join('cc.courseClassPeople', 'ccp')
            ->where('ccp.person = :person')
            ->andWhere('t.schoolYear = :schoolYear')
            ->andWhere('t.id = :timetable')
            ->setParameters($criteria)
            ->getQuery()
            ->getResult();
    }
}