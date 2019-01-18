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
 * Date: 9/12/2018
 * Time: 08:41
 */
namespace App\Controller;

use App\Entity\Notification;
use App\Manager\NotificationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NotificationController
 * @package App\Controller
 */
class NotificationController extends AbstractController
{
    /**
     * notificationShow
     * @param NotificationManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/notification/show/", name="notifications_show")
     * @IsGranted("IS_FULLY_AUTHENTICATED")
     */
    public function show(NotificationManager $manager)
    {
        $manager->setNotifications();

        return $this->render('Notification/show.html.twig',
            [
                'manager' => $manager,
            ]
        );
    }

    /**
     * details
     * @param NotificationManager $manager
     * @return JsonResponse
     * @throws \Exception
     * @Route("/notification/details/", name="api_notification_details")
     */
    public function details(Request $request, NotificationManager $manager)
    {
        if ($this->isGranted('ROLE_USER')) {

            $manager->setNotifications();
            if ($request->getContentType() !== 'json')
                return $this->render('Default/dump.html.twig', [
                    'count' => $manager->getCount(),
                    'redirect' => false,
                ]);
            return new JsonResponse(
                [
                    'count' => $manager->getCount(),
                    'redirect' => false,
                ], 200);
        }
        if ($request->getContentType() !== 'json')
            return $this->render('Default/dump.html.twig', [
                'count' => $manager->getCount(),
                'redirect' => true,
            ]);
        return new JsonResponse(
            [
                'count' => 0,
                'redirect' => true,
            ], 200);
    }

    /**
     * delete
     * @param Notification $id
     * @param NotificationManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/notification/{id}/delete/", name="notification_delete")
     * @IsGranted("IS_FULLY_AUTHENTICATED")
     */
    public function delete(Notification $id, NotificationManager $manager)
    {
        $manager->deleteNotification($id);
        $manager->setNotifications();

        return $this->render('Notification/show.html.twig',
            [
                'manager' => $manager,
            ]
        );
    }

    /**
     * archive
     * @param Notification $id
     * @param NotificationManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/notification/{id}/archive/", name="notification_archive")
     * @IsGranted("IS_FULLY_AUTHENTICATED")
     */
    public function archive(Notification $id, NotificationManager $manager)
    {
        $manager->archiveNotification($id);
        $manager->setNotifications();

        return $this->render('Notification/show.html.twig',
            [
                'manager' => $manager,
            ]
        );
    }

    /**
     * deleteAll
     * @param NotificationManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/notification/archive/all/", name="notification_archive_all")
     * @IsGranted("IS_FULLY_AUTHENTICATED")
     */
    public function archiveAll(NotificationManager $manager)
    {
        $manager->archiveAllNotification();
        $manager->setNotifications();

        return $this->render('base.html.twig');
    }
}