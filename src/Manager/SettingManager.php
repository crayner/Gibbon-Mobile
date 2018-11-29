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
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Manager;

use App\Entity\Setting;
use App\Manager\Traits\EntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SettingManager
 * @package App\Manager
 */
class SettingManager implements ContainerAwareInterface
{
    use EntityTrait;

    /**
     * @var string
     */
    private $entityName = Setting::class;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ArrayCollection
     */
    private $settings;

    /**
     * SettingManager constructor.
     * this will overwrite the trait constructor, so it MUST implement the same functions as the trait.
     * @param ContainerInterface $container
     * @param MessageManager $messageManager
     * @throws \Exception
     */
    public function __construct(ContainerInterface $container, MessageManager $messageManager)
    {
        $this->entityManager = $container->get('doctrine')->getManager();
        $this->messageManager = $messageManager;
        self::$entityRepository = $this->getRepository();
        $this->authorizationChecker = $container->get('security.authorization_checker');
        $this->router = $container->get('router');
        $this->setContainer($container);
        $this->settings = $this->loadSettingCache();
    }

    /**
     * @var Request|null
     */
    private $request;

    /**
     * getRequest
     *
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        if ($this->request instanceof Request)
            return $this->request;
        $stack = $this->getContainer()->get('request_stack');
        return $this->request = $stack->getCurrentRequest();
    }

    /**
     * hasRequest
     * @return bool
     */
    private function hasRequest()
    {
        if ($this->getRequest() instanceof Request)
            return true;
        return false;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * setContainer
     *
     * @param ContainerInterface|null $container
     * @return SettingManager
     */
    public function setContainer(?ContainerInterface $container = null): SettingManager
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @var SessionInterface|null
     */
    private $session;

    /**
     * getSession
     *
     * @return SessionInterface|null
     */
    public function getSession(): ?SessionInterface
    {
        if ($this->session instanceof SessionInterface)
            return $this->session;
        if ($this->getRequest() && $this->getRequest()->hasSession())
            return $this->session = $this->getRequest()->getSession();
        return null;
    }

    /**
     * hasSession
     * @return bool
     */
    public function hasSession(): bool
    {
        return $this->hasRequest() ? $this->getRequest()->hasSession() : false ;
    }

    /**
     * getSettingByScope
     * @param string $scope
     * @param string $name
     * @return bool|string|null
     * @throws \Exception
     */
    public function getSettingByScope(string $scope, string $name, bool $returnEntity = false)
    {
        $setting = $this->getSettingFromCache($scope, $name) ?: $this->findOneBy(['scope' => $scope, 'name' => $name]);
        if ($setting instanceof Setting) {
            return $this->addSettingToCache($setting, $returnEntity);
        }
        return false;
    }

    /**
     * addSettingToCache
     * @param Setting $setting
     * @param bool $returnEntity
     * @param bool $overwrite
     * @return Setting|string|null
     */
    private function addSettingToCache(Setting $setting, bool $returnEntity = false, bool $overwrite = false)
    {
        $scope = $this->getSettings()->containsKey($setting->getScope()) ? $this->getSettings()->get($setting->getScope()) : new ArrayCollection();
        if ($scope->containsKey($setting->getName()) && ! $overwrite)
            return $returnEntity ? $setting : $setting->getValue();
        $scope->set($setting->getName(), $setting);
        $this->settings->set($setting->getScope(), $scope);
        return $returnEntity ? $setting : $setting->getValue();
    }

    /**
     * getSettings
     * @return ArrayCollection
     */
    private function getSettings(): ArrayCollection
    {
        if (empty($this->settings) || ! $this->settings instanceof $this->settings)
            $this->settings = new ArrayCollection();
        return $this->settings;
    }

    /**
     * getSettingFromCache
     * @param string $scope
     * @param string $name
     * @return Setting|null
     */
    private function getSettingFromCache(string $scope, string $name): ?Setting
    {
        if (! $this->getSettings()->containsKey($scope))
            return null;

        if ($this->getSettings()->get($scope)->containsKey($name))
            return $this->getSettings()->get($scope)->get($name);
        return null;
    }

    /**
     * loadSettingCache
     * @return ArrayCollection
     */
    private function loadSettingCache(): ArrayCollection
    {
        if ($this->hasSession())
            $this->settings = $this->getSession()->get('setting_cache');
        return $this->getSettings();
    }

    /**
     * saveSettingCache
     * Called by SettingListener onTerminate
     */
    public function saveSettingCache(): void
    {
        if ($this->hasSession())
            $this->getSession()->set('setting_cache', $this->settings);
    }

    /**
     * createSetting
     * @param Setting $setting
     * @param bool $overwrite
     * @return SettingManager
     * @throws \Exception
     */
    public function createSetting(Setting $setting, bool $overwrite = false): SettingManager
    {
        $exists = $this->getSettingByScope($setting->getScope(), $setting->getName());
        if ($exists instanceof Setting)
        {
            $exists->setValue($setting->getValue());
            if ($overwrite) {
                $exists->setNameDisplay($setting->getNameDisplay());
                $exists->setDescription($setting->getDescription());
                $exists->setName($setting->getName());
                $exists->setScope($setting->getScope());
            }
            $setting = $exists;
        }
        $this->getEntityManager()->persist($setting);
        $this->getEntityManager()->flush();
        $this->addSettingToCache($setting, true);
        return $this;
    }

    /**
     * getParameter
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function getParameter(string $name, $default = null)
    {
        return $this->getContainer()->hasParameter($name) ? $this->getContainer()->getParameter($name) : $default ;
    }

    /**
     * getSettingByScopeAsInteger
     * @param string $scope
     * @param string $name
     * @param int $default
     * @return int
     * @throws \Exception
     */
    public function getSettingByScopeAsInteger(string $scope, string $name, int $default = 0): int
    {
        $result = $this->getSettingByScope($scope, $name);
        if (empty($result))
            return $default;
        return intval($result);
    }

    /**
     * getSettingByScopeAsArray
     * @param string $scope
     * @param string $name
     * @param array $default
     * @return array
     * @throws \Exception
     */
    function getSettingByScopeAsArray(string $scope, string$name, array $default = []): array
    {
        $result = $this->getSettingByScope($scope, $name);
        if (empty($result))
            return $default;
        return explode(',', $result);
    }

    /**
     * getSettingByScopeAsArray
     * @param string $scope
     * @param string $name
     * @param array $default
     * @return array
     * @throws \Exception
     */
    function getSettingByScopeAsDate(string $scope, string $name, ?\DateTime $default = null)
    {
        $result = $this->getSettingByScope($scope, $name);
        if (empty($result))
            return $default;
        return unserialize($result);
    }

    /**
     * getSettingByScopeAsBoolean
     * @param string $scope
     * @param string $name
     * @param bool|null $default
     * @return bool|null
     * @throws \Exception
     */
    function getSettingByScopeAsBoolean(string $scope, string $name, ?bool $default = null)
    {
        $result = $this->getSettingByScope($scope, $name);
        if (empty($result))
            return $default;
        return $result === 'Y' ? true : false ;
    }

    /**
     * getSettingByScopeAsString
     * @param string $scope
     * @param string $name
     * @param string|null $default
     * @return string|null
     * @throws \Exception
     */
    function getSettingByScopeAsString(string $scope, string $name, ?string $default = null)
    {
        $result = $this->getSettingByScope($scope, $name);
        if (empty($result))
            return $default;
        return strval($result);
    }
}