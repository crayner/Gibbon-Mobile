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
     * @param string $date
     * @return JsonResponse|Response
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

