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
 * Date: 18/12/2018
 * Time: 16:35
 */
namespace App\Manager;

use App\Entity\User;
use App\Util\UserHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DashboardManager
 * @package App\Manager
 */
abstract class DashboardManager implements DashboardInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var MessageManager
     */
    private $messageManager;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $timezone;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var Request
     */
    private $stack;

    /**
     * DashboardManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param MessageManager $messageManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param RouterInterface $router
     * @param ContainerInterface $container
     */
    public function __construct(EntityManagerInterface $entityManager, MessageManager $messageManager,
                                AuthorizationCheckerInterface $authorizationChecker,
                                RouterInterface $router, ContainerInterface $container, TranslatorInterface $translator, RequestStack $stack)
    {
        $this->entityManager = $entityManager;
        $this->messageManager = $messageManager;
        $this->authorizationChecker = $authorizationChecker;
        $this->router = $router;
        $this->timezone = $container->getParameter('timezone');
        $this->translator = $translator;
        $this->stack = $stack;
    }

    /**
     * @var ArrayCollection
     */
    private $providers;

    /**
     * getProvider
     * @param string $providerName
     * @return EntityProviderInterface
     */
    public function getProvider(string $providerName): EntityProviderInterface
    {
        if (! $this->getProviders()->containsKey($providerName))
            $this->addProvider($providerName);

        return $this->getProviders()->get($providerName);
    }

    /**
     * getProviders
     * @return ArrayCollection
     */
    public function getProviders(): ArrayCollection
    {
        if(empty($this->providers))
            $this->providers = new ArrayCollection();
        return $this->providers;
    }

    /**
     * addProvider
     * @param string $providerName
     * @return DashboardInterface
     */
    private function addProvider(string $providerName): DashboardInterface
    {
        if (class_exists($providerName))
            $this->getProviders()->set($providerName, new $providerName($this->getEntityManager(), $this->getMessageManager(), $this->getAuthorizationChecker(), $this->getRouter()));

        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @return MessageManager
     */
    public function getMessageManager(): MessageManager
    {
        return $this->messageManager;
    }

    /**
     * @return AuthorizationCheckerInterface
     */
    public function getAuthorizationChecker(): AuthorizationCheckerInterface
    {
        return $this->authorizationChecker;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * getTimetableProps
     * @return array
     */
    public function getTimetableProps(): array
    {
        $translations['My Timetable'] = $this->getTranslator()->trans('My Timetable');
        $translations['Loading'] = $this->getTranslator()->trans('Loading');
        $translations['School Closed'] = $this->getTranslator()->trans('School Closed');
        $translations['Next Day'] = $this->getTranslator()->trans('Next Day');
        $translations['Previous Day'] = $this->getTranslator()->trans('Previous Day');
        $translations['Today'] = $this->getTranslator()->trans('Today');
        $translations['Phone'] = $this->getTranslator()->trans('Phone');

        $properties['translations'] = $translations;
        $properties['locale'] = $this->getRequest()->get('_locale');
        $properties['person'] = UserHelper::getCurrentUser()->getId();
        return $properties;
    }

    /**
     * getTranslator
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * getRequest
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->stack->getCurrentRequest();
    }
}