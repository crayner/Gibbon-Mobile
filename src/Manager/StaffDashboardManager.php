<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 18/12/2018
 * Time: 16:34
 */
namespace App\Manager;

use App\Entity\Person;
use App\Provider\PlannerEntryProvider;
use App\Util\UserHelper;

/**
 * Class StaffDashboardManager
 * @package App\Manager
 */
class StaffDashboardManager extends DashboardManager
{
    /**
     * getDashboardName
     * @return string
     */
    public function getDashboardName(): string
    {
        return 'Staff Dashboard';
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
            $this->lessonContent = $this->getProvider(PlannerEntryProvider::class)->getStaffDashboardContent($this->getTimezone());
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