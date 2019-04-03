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

        return array_merge($results,
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
    }
}