<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
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