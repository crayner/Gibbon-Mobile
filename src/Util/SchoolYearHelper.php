<?php
/**
 * Created by PhpStorm.
 *
 * This file is part of the Busybee Project.
 *
 * (c) Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * UserProvider: craig
 * Date: 23/06/2018
 * Time: 08:11
 */
namespace App\Util;

use App\Entity\DaysOfWeek;
use App\Entity\SchoolYear;
use App\Entity\SchoolYearTerm;
use App\Manager\SchoolYearManager;
use App\Repository\SchoolYearRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SchoolYearHelper
 * @package App\Util
 */
class SchoolYearHelper
{
    /**
     * @var \App\Repository\SchoolYearRepository|\Doctrine\Common\Persistence\ObjectRepository 
     */
    private static $schoolYearRepository;

    /**
     * @var SchoolYearManager
     */
    private static $manager;

    /**
     * SchoolYearHelper constructor.
     *
     * @param SchoolYearManager $manager
     * @param UserHelper $userHelper
     * @throws \Exception
     */
    public function __construct(SchoolYearManager $manager, UserHelper $userHelper)
    {
        self::$schoolYearRepository = $manager->getRepository();
        self::$manager = $manager;
    }

    /**
     * @var SchoolYear|null
     */
    private static $currentSchoolYear;
    
    /**
     * getCurrentSchoolYear
     *
     * @return SchoolYear|null
     */
    public static function getCurrentSchoolYear(): ?SchoolYear
    {
        if (! is_null(self::$currentSchoolYear))
            return self::$currentSchoolYear;

        UserHelper::getCurrentUser();
        if (UserHelper::getCurrentUser() instanceof UserInterface) {
            self::$currentSchoolYear = self::$manager->getSession()->get('school_year') ?: self::$schoolYearRepository->findOneBy(['status' => 'current']);
            self::$manager->getSession()->get('school_year', self::$currentSchoolYear);
        } else {
            self::$currentSchoolYear = self::$schoolYearRepository->findOneBy(['status' => 'current']);
            self::$manager->getSession()->remove('school_year');
        }
        return self::$currentSchoolYear;
    }

    /**
     * @return SchoolYearRepository
     */
    public static function getSchoolYearRepository(): SchoolYearRepository
    {
        return self::$schoolYearRepository;
    }

    /**
     * @var SchoolYear|null
     */
    private static $nextSchoolYear;

    /**
     * getNextSchoolYear
     *
     * @param SchoolYear|null $schoolYear
     * @return SchoolYear|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public static function getNextSchoolYear(SchoolYear $schoolYear = null): ?SchoolYear
    {
        if (self::$nextSchoolYear && is_null($schoolYear))
            return self::$nextSchoolYear;

        $schoolYear = $schoolYear ?: self::getCurrentSchoolYear();

        self::$nextSchoolYear = self::getSchoolYearRepository()->createQueryBuilder('y')
            ->where('y.firstDay > :firstDay')
            ->setParameter('firstDay', $schoolYear->getFirstDay()->format('Y-m-d'))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return self::$nextSchoolYear;
    }

    /**
     * getWeekNumber
     * @param \DateTime $date
     * @return int|string
     */
    public static function getWeekNumber(\DateTime $date): int
    {
        $results = EntityHelper::getRepository(SchoolYearTerm::class)->findBy(['schoolYear' => self::getCurrentSchoolYear()],['sequenceNumber' => 'ASC']);
        $week = 0;
        foreach($results as $term){
            $firstDayStamp = clone $term->getFirstDay();
            $lastDayStamp = clone $term->getLastDay();
            while ($firstDayStamp->format('N') !== '1')  //   This will work regardless of i18n settings.
                $firstDayStamp->sub(new \DateInterval('P1D'));

            $lastDayStamp->add(new \DateInterval('PT23H59M59S'));

            while ($firstDayStamp <= $date && $firstDayStamp < $lastDayStamp) {
                $firstDayStamp->add(new \DateInterval('P1W'));
                $week++;
            }
            if ($firstDayStamp < $lastDayStamp)
                break;
        }
        return $week;

//        $week = $date->format('W');
//        return $week - self::getCurrentSchoolYear()->getFirstDay()->format('W') + 1;
    }

    /**
     * isDayInTerm
     * @param \DateTime $date
     * @return bool
     */
    public static function isDayInTerm(\DateTime $date): bool
    {
        return EntityHelper::getRepository(SchoolYearTerm::class)->isDayInTerm($date);
    }

    /**
     * @param \DateTime $date
     * @return SchoolYearTerm|null
     */
    public static function findOneTermByDay(\DateTime $date): ?SchoolYearTerm
    {
        return EntityHelper::getRepository(SchoolYearTerm::class)->findOneByDay($date);
    }

    /**
     * getSchoolYearAsArray
     * @param SchoolYear|null $schoolYear
     * @return mixed
     */
    public static function getSchoolYearAsArray(?SchoolYear $schoolYear = null)
    {
        $schoolYear = $schoolYear ?: self::getCurrentSchoolYear();
        return self::$manager->getProvider()->findAsArray($schoolYear);
    }

    /**
     * getDaysOfWeek
     * @return array
     */
    public static function getDaysOfWeek(): array
    {
        return EntityHelper::getRepository(DaysOfWeek::class)->findAllAsArray();
    }

//Checks to see if a specified date (YYYY-MM-DD) is a day where school is open in the current academic year. There is an option to search all years
    function isSchoolOpen($guid, $date, $connection2, $allYears = '')
    {
        //Set test variables
        $isInTerm = false;
        $isSchoolDay = false;
        $isSchoolOpen = false;

        //Turn $date into UNIX timestamp and extract day of week
        $timestamp = dateConvertToTimestamp($date);
        $dayOfWeek = date('D', $timestamp);

        //See if date falls into a school term
        try {
            $data = array();
            $sqlWhere = '';
            if ($allYears != true) {
                $data[$_SESSION[$guid]['gibbonSchoolYearID']] = $_SESSION[$guid]['gibbonSchoolYearID'];
                $sqlWhere = ' AND gibbonSchoolYear.gibbonSchoolYearID=:'.$_SESSION[$guid]['gibbonSchoolYearID'];
            }

            $sql = "SELECT gibbonSchoolYearTerm.firstDay, gibbonSchoolYearTerm.lastDay FROM gibbonSchoolYearTerm, gibbonSchoolYear WHERE gibbonSchoolYearTerm.gibbonSchoolYearID=gibbonSchoolYear.gibbonSchoolYearID $sqlWhere";
            $result = $connection2->prepare($sql);
            $result->execute($data);
        } catch (PDOException $e) {
        }
        while ($row = $result->fetch()) {
            if ($date >= $row['firstDay'] and $date <= $row['lastDay']) {
                $isInTerm = true;
            }
        }

        //See if date's day of week is a school day
        if ($isInTerm == true) {
            try {
                $data = array('nameShort' => $dayOfWeek);
                $sql = "SELECT * FROM gibbonDaysOfWeek WHERE nameShort=:nameShort AND schoolDay='Y'";
                $result = $connection2->prepare($sql);
                $result->execute($data);
            } catch (PDOException $e) {
            }
            if ($result->rowCount() > 0) {
                $isSchoolDay = true;
            }
        }

        //See if there is a special day
        if ($isInTerm == true and $isSchoolDay == true) {
            try {
                $data = array('date' => $date);
                $sql = "SELECT * FROM gibbonSchoolYearSpecialDay WHERE type='School Closure' AND date=:date";
                $result = $connection2->prepare($sql);
                $result->execute($data);
            } catch (PDOException $e) {
            }

            if ($result->rowCount() < 1) {
                $isSchoolOpen = true;
            }
        }

        return $isSchoolOpen;
    }
}
