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
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Repository;

use App\Entity\AttendanceLogCourseClass;
use App\Entity\CourseClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class AttendanceLogCourseClassRepository
 * @package App\Repository
 */
class AttendanceLogCourseClassRepository extends ServiceEntityRepository
{
    /**
     * AttendanceLogCourseClassRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AttendanceLogCourseClass::class);
    }

    /**
     * isAttendanceTaken
     * @param int $class
     * @param \DateTime $date
     * @return bool
     */
    public function isAttendanceTaken(int $class, \DateTime $date): bool
    {
        if (empty($this->createQueryBuilder('alcc')
            ->join('alcc.courseClass', 'cc')
            ->where('alcc.date = :date')
            ->setParameter('date', $date)
            ->andWhere('cc.id = :ccid')
            ->setParameter('ccid', $class)
            ->getQuery()
            ->getResult()))
            return false;
        return true;
    }
}
