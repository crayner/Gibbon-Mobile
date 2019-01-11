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
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Listener;

use App\Manager\MessageManager;
use App\Manager\SchoolYearManager;
use App\Provider\ActionProvider;
use App\Provider\FamilyAdultProvider;
use App\Provider\FamilyChildProvider;
use App\Provider\FamilyProvider;
use App\Provider\ModuleProvider;
use App\Provider\PersonProvider;
use App\Provider\SchoolYearProvider;
use App\Provider\TimetableProvider;
use App\Util\EntityHelper;
use App\Util\FormatHelper;
use App\Util\RelationshipHelper;
use App\Util\SchoolYearHelper;
use App\Util\SecurityHelper;
use App\Util\TimetableHelper;
use App\Util\UserHelper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class HelperListener
 *
 * This class simply pre loads static helpers.
 *
 * @package App\Listener
 */
class HelperListener implements EventSubscriberInterface
{
    /**
     * HelperListener constructor.
     * @param EntityManagerInterface $entityManager
     * @param MessageManager $messageManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param RouterInterface $router
     * @param TokenStorageInterface $tokenStorage
     * @param RequestStack $stack
     * @param TranslatorInterface $translator
     * @param ContainerInterface $container
     * @param LoggerInterface $logger
     * @throws \Exception
     */
    public function __construct(EntityManagerInterface $entityManager, MessageManager $messageManager,
                                AuthorizationCheckerInterface $authorizationChecker,
                                RouterInterface $router, TokenStorageInterface $tokenStorage, RequestStack $stack, TranslatorInterface $translator, ContainerInterface $container, LoggerInterface $logger)
    {
        new EntityHelper($entityManager);
        new RelationshipHelper(new FamilyProvider($entityManager, $messageManager, $authorizationChecker, $router), new FamilyAdultProvider($entityManager, $messageManager, $authorizationChecker, $router), new FamilyChildProvider($entityManager, $messageManager, $authorizationChecker, $router));
        new SchoolYearHelper(new SchoolYearManager($stack, new SchoolYearProvider($entityManager, $messageManager, $authorizationChecker, $router)), new UserHelper($tokenStorage, new PersonProvider($entityManager, $messageManager, $authorizationChecker, $router)));
        new FormatHelper($translator, $container);
        new SecurityHelper(new ActionProvider($entityManager, $messageManager, $authorizationChecker, $router), new ModuleProvider($entityManager, $messageManager, $authorizationChecker, $router), $logger);
        new TimetableHelper(new TimetableProvider($entityManager, $messageManager, $authorizationChecker, $router));
    }

    /**
     * getSubscribedEvents
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $listeners = [
            KernelEvents::REQUEST => 'doNothing',
        ];

        return $listeners;
    }

    /**
     * doNothing
     */
    public function doNothing(){}
}