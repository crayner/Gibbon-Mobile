<?php
/**
 * Created by PhpStorm.
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