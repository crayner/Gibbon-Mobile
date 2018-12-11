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

use App\Manager\NotificationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NotificationController
 * @package App\Controller
 */
class NotificationController extends Controller
{
    /**
     * notificationCount
     * @param NotificationManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/notification/count/", name="notification_count")
     */
    public function count(NotificationManager $manager)
    {
        $manager->getCount();

        return $this->render('base.html.twig');
    }

    /**
     * details
     * @param NotificationManager $manager
     * @return JsonResponse
     * @throws \Exception
     * @Route("/notification/details/", name="notification_details")
     * @IsGranted("ROLE_USER")
     */
    public function details(NotificationManager $manager)
    {
        $manager->setNotifications();
        return new JsonResponse(
            [
                'count' => $manager->getCount(),
            ],200);
    }
}