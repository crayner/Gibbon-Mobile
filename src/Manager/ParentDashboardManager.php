<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 9/04/2019
 * Time: 11:12
 */

namespace App\Manager;

use App\Entity\Person;
use App\Provider\FamilyChildProvider;
use App\Util\UserHelper;

class ParentDashboardManager extends DashboardManager
{
    /**
     * @var bool
     */
    protected $displayLessons = false;

    /**
     * getDashboardName
     * @return string
     */
    public function getDashboardName(): string
    {
        return 'Parent Dashboard';
    }

    /**
     * getLessonContent
     * @return array
     */
    public function getLessonContent(): array
    {
        return [];
    }

    /**
     * getProperties
     * @return array
     */
    public function getProperties(): array
    {
        $properties = $this->getTimetableProps();
        $properties['canTakeAttendance'] = true;
        return $properties;
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