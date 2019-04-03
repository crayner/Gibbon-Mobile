<?php
/**
 * Created by PhpStorm.
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
     * @param SessionInterface|null $session
     */
    public function __construct(RequestStack $stack, SchoolYearProvider $provider, ?SessionInterface $session = null)
    {
        $this->stack = $stack;
        $this->provider = $provider;
        $this->setSession($session);
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
        if (($this->getRequest() && $this->getRequest()->hasSession()) || $this->session instanceof SessionInterface)
            return $this->session = $this->session ?: $this->getRequest()->getSession();
        return null;
    }

    /**
     * @param SessionInterface $session
     * @return SchoolYearManager
     */
    public function setSession(?SessionInterface $session): SchoolYearManager
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest(): ?Request
    {
        return $this->request = $this->request ?: $this->stack->getCurrentRequest();
    }
}