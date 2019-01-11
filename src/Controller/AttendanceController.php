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
 * Date: 8/01/2019
 * Time: 08:34
 */
namespace App\Controller;

use App\Entity\TTDayRowClass;
use App\Manager\AttendanceManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AttendanceController
 * @package App\Controller
 */
class AttendanceController extends AbstractController
{
    /**
     * takeClass
     * @param TTDayRowClass $class
     * @param \DateTime $date
     * @param AttendanceManager $manager
     * @param TranslatorInterface $translator
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/attendance/timetable/{class}/class/{date}/date/take/", name="attendance_take_class")
     */
    public function takeClass(TTDayRowClass $class, \DateTime $date, AttendanceManager $manager, TranslatorInterface $translator, Request $request)
    {
        if ($this->isGranted('ROLE_ACTION', ['/modules/Attendance/attendance_take_byCourseClass.php']))
        {
            $manager->takeClassAttendance($class, $date);

            if ($request->getContentType() === 'json')
                return new JsonResponse([
                    'messages' => $manager->getMessageManager()->getTranslatedMessages($translator),
                    'content' => $manager->__toArray(),
                    'redirect' =>false
                ], 200);
            return $this->render('Default/dump.html.twig', [
                'manager' => $manager,
                'messages' => $manager->getMessageManager()->getTranslatedMessages($translator),
                'content' => $manager->__toArray(),
            ]);
        }
        $manager->getMessageManager()->add('danger', 'You do not have access to this action.');
        return new JsonResponse([
            'messages' => $manager->getMessageManager()->getTranslatedMessages($translator),
            'content' => [],
            'redirect' => true,
        ], 200);
    }

    /**
     * storeClass
     * @param Request $request
     * @param AttendanceManager $manager
     * @Route("/attendance/class/record/", methods={"POST"}, name="api_attendance_record_class")
     */
    public function storeClassAttendance(Request $request, AttendanceManager $manager, TranslatorInterface $translator)
    {
        if ($this->isGranted('ROLE_ACTION', ['/modules/Attendance/attendance_take_byCourseClass.php'])){
            $manager->handleClassRequest($request);

            return new JsonResponse([
                'messages' => $manager->getMessageManager()->getTranslatedMessages($translator),
                'content' => $manager->__toArray(),
                'redirect' => false,
            ]);
        }
        $manager->getMessageManager()->add('danger', 'You do not have access to this action.');
        return new JsonResponse([
            'messages' => $manager->getMessageManager()->getTranslatedMessages($translator),
            'content' => [],
            'redirect' => true,
        ], 200);
    }
}