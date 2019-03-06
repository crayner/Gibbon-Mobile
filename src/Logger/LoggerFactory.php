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
 * Date: 20/02/2019
 * Time: 10:36
 */

namespace App\Logger;

use App\Manager\SettingManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\ConnectionException;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoggerFactory implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ArrayCollection
     */
    private $loggerStack;

    /**
     * @param string $channel
     * @return mixed
     */
    public function getLogger(string $channel = 'gibbon')
    {
        if ($this->getLoggerStack()->containsKey('monolog.logger.'.$channel))
            return $this->getLoggerStack()->get('monolog.logger.'.$channel);

        $logger = $this->getContainer()->get('monolog.logger.'.$channel);

        $this->getLoggerStack()->set('monolog.logger.'.$channel, $logger);

        return $logger;
    }

    /**
     * @var int
     */
    private $keepDays = 7;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var int
     */
    private $loggerLevel = 100;

    /**
     * LoggerFactory constructor.
     * @param ContainerInterface $container
     * @param SettingManager $settingGateway
     * @throws \Exception
     */
    public function __construct(ContainerInterface $container, SettingManager $settingGateway)
    {
        $this->setContainer($container);
        try {
            $this->filePath = $settingGateway->getSettingByScope('System', 'absolutePath') . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR;
            $this->loggerLevel = $settingGateway->getSettingByScope('System', 'installType') === 'Production' ? Logger::WARNING : Logger::DEBUG;
        } catch (ConnectionException $e) {
            $this->filePath =  $this->getContainer()->get('kernel')->getProjectDir() . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR;
            $this->loggerLevel = Logger::DEBUG;
        }
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     * @return LoggerFactory
     */
    public function setFilePath(string $filePath): LoggerFactory
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * @return int
     */
    public function getLoggerLevel(): int
    {
        return $this->loggerLevel;
    }

    /**
     * @return int
     */
    public function getKeepDays(): int
    {
        return $this->keepDays;
    }

    /**
     * getContainer
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * setContainer
     * @param ContainerInterface|null $container
     * @return LoggerFactory
     */
    public function setContainer(ContainerInterface $container = null): LoggerFactory
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLoggerStack(): ArrayCollection
    {
        return $this->loggerStack = $this->loggerStack ?: new ArrayCollection();
    }
}