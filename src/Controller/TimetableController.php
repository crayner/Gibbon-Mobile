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
 * Time: 11:23
 */
namespace App\Controller;

use App\Entity\Person;
use App\Manager\GoogleAPIManager;
use App\Manager\TimetableRenderManager;
use App\Util\UserHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TimetableController
 * @package App\Command
 */
class TimetableController extends AbstractController
{
    /**
     * myTimetable
     * @param string $date
     * @return JsonResponse
     * @Route("/timetable/{date}/{person}/display/", name="api_timetable_display")
     * @Security("is_granted('ROLE_ACTION', ['/modules/Timetable/tt.php'])")
     */
    public function myTimetable(TimetableRenderManager $manager, Person $person, string $date = 'today')
    {
        $date = $manager->manageDateChange($date);
        return new JsonResponse([
            'content' => $manager->render($person, new \DateTime($date, new \DateTimeZone($this->getParameter('timezone')))),
        ],200);
    }

    /**
     * schoolTimetable
     * @param TimetableRenderManager $manager
     * @param string $date
     * @return JsonResponse
     * @throws \Exception
     * @Route("/timetable/{date}/school/", name="api_timetable_school_display")
     * @Security("is_granted('ROLE_ACTION', ['/modules/Timetable/tt.php'])")
     */
    public function schoolTimetable(TimetableRenderManager $manager, string $date = 'today')
    {
        $date = $manager->manageDateChange($date);
        $googleManager = new GoogleAPIManager(UserHelper::getCurrentUser(), $manager->getGoogleAuthenticator());
        $schoolAvailable = $manager->getSettingManager()->getSettingByScopeAsString('System', 'calendarFeed', false);
        return new JsonResponse([
            'content' => $googleManager->getCalendarEvents($schoolAvailable, new \DateTime($date)),
        ],200);
    }

}

