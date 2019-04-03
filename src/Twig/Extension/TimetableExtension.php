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
 * Time: 10:03
 */
namespace App\Twig\Extension;

use App\Manager\DashboardInterface;
use Twig\Extension\AbstractExtension;

/**
 * Class TimetableExtension
 * @package App\Twig\Extension
 */
class TimetableExtension extends AbstractExtension
{
    /**
     * getName
     * @return string
     */
    public function getName()
    {
        return 'timetable_extension';
    }

    /**
     * getFunctions
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('hasTimetable', array($this, 'hasTimetable')),
        ];
    }

    /**
     * hasTimetable
     * @param $manager
     * @return bool
     */
    public function hasTimetable($manager): bool
    {
        if (method_exists($manager,'hasTimetable'))
            return $manager->hasTimetable();

        return false;
    }
}