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
 * Date: 12/12/2018
 * Time: 10:33
 */
namespace App\Controller;

use App\Manager\MessengerManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MessengerController
 * @package App\Controller
 */
class MessengerController extends AbstractController
{

    /**
     * details
     * @param MessengerManager $manager
     * @param SessionInterface $session
     * @return JsonResponse
     * @throws \Exception
     * @Route("/messenger/details/", name="api_messenger_details")
     */
    public function details(MessengerManager $manager, SessionInterface $session)
    {
        if (! $this->isGranted('ROLE_ACTION', ['/modules/Messenger/messageWall_view.php']))
            return new JsonResponse(
                [
                    'count' => 0,
                    'redirect' => true,
                ],200);

        if ($session->get('messenger_md5') !== md5(json_encode($manager->getMessagesByType()))) {
            $manager->setMessages();
            $session->set('messenger_md5', md5(json_encode($manager->getMessagesByType())));
            $session->set('messenger_count', $manager->getMessageCount());
        } else
            $manager->setMessageCount(intval($session->get('messenger_count') ?: 0));

        return new JsonResponse(
            [
                'count' => $manager->getMessageCount(),
                'redirect' => false,
            ],200);
    }

    /**
     * show
     * @param MessengerManager $manager
     * @return mixed
     * @Route("/messenger/{showDate}/show/", name="messenger_show")
     * @Security("is_granted('ROLE_ACTION', ['/modules/Messenger/messageWall_view.php'])")
     */
    public function show(MessengerManager $manager, string $showDate = 'today')
    {
        $manager->setMessages($showDate);

        return $this->render('Messenger/show.html.twig',
            [
                'manager' => $manager,
            ]
        );
    }
}