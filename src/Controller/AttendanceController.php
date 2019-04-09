<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 8/01/2019
 * Time: 08:34
 */
namespace App\Controller;

use App\Entity\RollGroup;
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
                    'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
                    'content' => $manager->__toArray(),
                    'redirect' =>false
                ], 200);
            return $this->render('Default/dump.html.twig', [
                'manager' => $manager,
                'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
                'content' => $manager->__toArray(),
            ]);
        }
        $manager->getMessageManager()->add('danger', 'You do not have access to this action.', ['code' => 'notGranted']);
        return new JsonResponse([
            'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
            'content' => [],
            'redirect' => false,
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
                'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
                'content' => $manager->__toArray(),
                'redirect' => false,
            ]);
        }
        $manager->getMessageManager()->add('danger', 'You do not have access to this action.', ['code' => 'notGranted']);
        return new JsonResponse([
            'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
            'content' => [],
            'redirect' => true,
        ], 200);
    }

    /**
     * takeRoll
     * @param RollGroup $roll
     * @param \DateTime $date
     * @param AttendanceManager $manager
     * @param TranslatorInterface $translator
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/attendance/timetable/{roll}/roll/{date}/date/take/", name="attendance_take_roll")
     */
    public function takeRoll(RollGroup $roll, \DateTime $date, AttendanceManager $manager, TranslatorInterface $translator, Request $request)
    {
        if ($this->isGranted('ROLE_ACTION', ['/modules/Attendance/attendance_take_byRollGroup.php']))
        {
            $manager->takeRollAttendance($roll, $date);

            if ($request->getContentType() === 'json')
                return new JsonResponse([
                    'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
                    'content' => $manager->__toArray(),
                    'redirect' => false
                ], 200);
            return $this->render('Default/dump.html.twig', [
                'manager' => $manager,
                'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
                'content' => $manager->__toArray(),
            ]);
        }
        $manager->getMessageManager()->add('danger', 'You do not have access to this action.', ['code' => 'notGranted']);
        return new JsonResponse([
            'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
            'content' => [],
            'redirect' => false,
        ], 200);
    }

    /**
     * storeRoll
     * @param Request $request
     * @param AttendanceManager $manager
     * @Route("/attendance/roll/record/", methods={"POST"}, name="api_attendance_record_roll")
     */
    public function storeRollAttendance(Request $request, AttendanceManager $manager, TranslatorInterface $translator)
    {
        if ($this->isGranted('ROLE_ACTION', ['/modules/Attendance/attendance_take_byRollGroup.php'])){
            $manager->handleRollRequest($request);

            return new JsonResponse([
                'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
                'content' => $manager->__toArray(),
                'redirect' => false,
            ]);
        }
        $manager->getMessageManager()->add('danger', 'You do not have access to this action.', ['code' => 'notGranted']);
        return new JsonResponse([
            'messages' => $manager->getMessageManager()->serialiseTranslatedMessages($translator),
            'content' => [],
            'redirect' => true,
        ], 200);
    }
}