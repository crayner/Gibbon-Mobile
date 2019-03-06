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
 * Time: 08:03
 */
namespace App\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class LastActivityListener
 * @package App\Listener
 */
class LastActivityListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * LastActivityListener constructor.
     * @param ContainerInterface|null $container
     */
    public function __construct(ContainerInterface $container = null, TokenStorageInterface $tokenStorage = null)
    {
        $this->tokenStorage = $tokenStorage;
        $this->container = $container;
    }

    /**
     * getSubscribedEvents
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => array('onKernelRequest', 12),
        ];
    }

    /**
     * onKernelRequest
     * @param GetResponseEvent $event
     * @return RedirectResponse|void
     * @throws \Exception
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest())
             return ;

        $session = null;
        $request = $event->getRequest();

        $route = $request->get('_route');

        if (strpos($route, '_') === 0)
            return;
        if (strpos($route, 'api_') === 0)
            return;

        if (! $request->hasSession()) {
            if (method_exists($request, 'setSessionFactory')) {
                $request->setSessionFactory(function () {
                    $session = $this->getSession();
                });
            } elseif ($session = $this->getSession()) {
                $request->setSession($session);
            }
        } else
            $session = $request->getSession();

        $session->start();
        $timezone = $this->container->getParameter('timezone') ?: 'UTC';

        if ($route !== 'login') {
            if ($session->has('last_activity_time') && $session->has('_security_main')) {
                $now = new \DateTime('now', new \DateTimeZone($timezone));
                $interval = $now->diff($session->get('last_activity_time'));
                if (abs($interval->format('%i')) > $this->container->getParameter('idle_timeout')) {
                    $session->remove('_security_main');
                    $flashBag = $session->getFlashBag();
                    $flashBag->add('info', 'Your session expired, so you were automatically logged out of the system.');
                    return new RedirectResponse('/');
                }
            }
        }
        $session->set('last_activity_time', new \DateTime('now', new \DateTimeZone($timezone)));
    }
}