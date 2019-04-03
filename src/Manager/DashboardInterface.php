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
 * Time: 16:48
 */

namespace App\Manager;


interface DashboardInterface
{
    /**
     * getDashboardName
     * @return string
     */
    public function getDashboardName(): string;

    /**
     * getLessonContent
     * @return array
     */
    public function getLessonContent(): array;
}