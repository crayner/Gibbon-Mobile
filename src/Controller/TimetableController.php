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
 * Time: 11:23
 */
namespace App\Controller;

use App\Entity\Person;
use App\Manager\TimetableRenderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TimetableController
 * @package App\Command
 */
class TimetableController extends AbstractController
{
    /**
     * myTimetable
     * @param TimetableRenderManager $manager
     * @param Person $person
     * @param Request $request
     * @param string $date
     * @return JsonResponse|Response
     * @throws \Google_Exception
     * @throws \Exception
     * @Route("/timetable/{date}/{person}/display/", name="api_timetable_display")
     */
    public function myTimetable(TimetableRenderManager $manager, Person $person, Request $request, string $date = 'today')
    {
        if ($this->isGranted('ROLE_ACTION', ['/modules/Timetable/tt.php'])) {
            $date = $manager->manageDateChange($date);
            if ($request->getContentType() !== 'json')
                return $this->render('Default/dump.html.twig', [
                    'content' => $manager->render($person, new \DateTime($date, new \DateTimeZone($this->getParameter('timezone')))),
                    'redirect' => false,
                    'authenticated' => true,
                ]);
            return new JsonResponse([
                'content' => $manager->render($person, new \DateTime($date, new \DateTimeZone($this->getParameter('timezone')))),
                'redirect' => false,
            ], 200);
        } elseif ($request->getContentType() === 'json') {
            return new JsonResponse([
                'content' => [
                    'valid' => 'error',
                ],
                'redirect' => true,
            ], 200);
        } elseif ($request->getContentType() !== 'json')
            return $this->render('Default/dump.html.twig', [
                'content' => [
                    'valid' => 'error',
                ],
                'authenticated' => false,
                'redirect' => true,
            ]);
        return new JsonResponse([
            'content' => [
                'valid' => 'error',
            ],
            'redirect' => true,
        ], 200);
    }
}

