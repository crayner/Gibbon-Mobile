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
        return $this->getRepository()->findStaffDashboardContent($today->format('Y-m-d'), SchoolYearHelper::getCurrentSchoolYear(), UserHelper::getCurrentUser());
    }

    /**
     * getStaffDashboardContent
     * @param string $timezone
     * @return mixed
     * @throws \Exception
     */
    public function getStudentDashboardContent(string $timezone = 'UTC')
    {
        $today = new \DateTime('today', new \DateTimeZone($timezone));
        return $this->getRepository()->findStudentDashboardContent($today->format('Y-m-d'), SchoolYearHelper::getCurrentSchoolYear(), UserHelper::getCurrentUser());
    }
}