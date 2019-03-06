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
 * UserProvider: craig
 * Date: 24/11/2018
 * Time: 13:56
 */
namespace App\Manager;

use App\Entity\SchoolYear;
use App\Manager\Traits\EntityTrait;
use App\Provider\SchoolYearProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SchoolYearManager
 * @package App\Manager
 */
class SchoolYearManager
{
    /**
     * @var SchoolYearProvider
     */
    private $provider;

    /**
     * @var RequestStack
     */
    private $stack;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * SchoolYearManager constructor.
     * @param RequestStack $stack
     * @param SchoolYearProvider $provider
     */
    public function __construct(RequestStack $stack, SchoolYearProvider $provider)
    {
        $this->stack = $stack;
        $this->provider = $provider;
    }

    /**
     * getRepository
     * @param string $entityName
     * @return \Doctrine\Common\Persistence\ObjectRepository|null
     * @throws \Exception
     */
    public function getRepository(string $entityName = SchoolYear::class)
    {
        return $this->getProvider()->getRepository($entityName);
    }

    /**
     * @return SchoolYearProvider
     */
    public function getProvider(): SchoolYearProvider
    {
        return $this->provider;
    }

    /**
     * getSession
     * @return SessionInterface|null
     */
    public function getSession(): ?SessionInterface
    {
        if ($this->getRequest() && $this->getRequest()->hasSession())
            return $this->session = $this->session ?: $this->getRequest()->getSession();
        return null;
    }

    /**
     * @return Request
     */
    public function getRequest(): ?Request
    {
        return $this->request = $this->request ?: $this->stack->getCurrentRequest();
    }
}