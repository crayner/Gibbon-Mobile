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
 * Time: 08:27
 */
namespace App\Provider;

use App\Entity\PlannerEntry;
use App\Manager\EntityProviderInterface;
use App\Manager\Traits\EntityTrait;
use App\Util\SchoolYearHelper;
use App\Util\UserHelper;

/**
 * Class PlannerEntryProvider
 * @package App\Provider
 */
class PlannerEntryProvider implements EntityProviderInterface
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = PlannerEntry::class;

    /**
     * getStaffDashboardContent
     * @param string $timezone
     * @return mixed
     * @throws \Exception
     */
    public function getStaffDashboardContent(string $timezone = 'UTC')
    {
        $today = new \DateTime('today', new \DateTimeZone($timezone));
        $results = $this->getRepository()->createQueryBuilder('pe')
            ->select('pe, cc, c, ccp, sh')
            ->join('pe.courseClass', 'cc')
            ->join('cc.course', 'c')
            ->join('cc.courseClassPeople', 'ccp')
            ->leftJoin('pe.studentHomeworkEntries', 'sh', 'WITH', 'ccp.person = sh.person', 'pe.id')
            ->where('c.schoolYear = :schoolYear')
            ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
            ->andWhere('pe.date = :today')
            ->setParameter('today', $today->format('Y-m-d'))
            ->andWhere('ccp.person = :currentUser')
            ->setParameter('currentUser', UserHelper::getCurrentUser())
            ->getQuery()
            ->getResult();

        // with UNION of

        $results = array_merge($results,
            $this->getRepository()->createQueryBuilder('pe')
                ->select('pe, cc, c, peg')
                ->join('pe.courseClass', 'cc')
                ->join('pe.plannerEntryGuests', 'peg')
                ->join('cc.course', 'c')
                ->where('c.schoolYear = :schoolYear')
                ->setParameter('schoolYear', SchoolYearHelper::getCurrentSchoolYear())
                ->andWhere('pe.date = :today')
                ->setParameter('today', $today->format('Y-m-d'))
                ->andWhere('peg.person = :currentUser')
                ->setParameter('currentUser', UserHelper::getCurrentUser())
                ->getQuery()
                ->getResult()
            );
        dump($results);

        return $results;
    }
}