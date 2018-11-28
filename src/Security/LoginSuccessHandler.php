<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\ParameterBagUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
	use TargetPathTrait;
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	/**
	 * @var TokenStorageInterface
	 */
	private $tokenStorage;

	/**
	 * @var AuthenticationUtils
	 */
	private $authenticationUtils;

	/**
	 * @var RouterInterface
	 */
	private $router;

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * @var HttpUtils
	 */
	private $httpUtils;

	/**
	 * @var array
	 */
	private $securityRoutes;

	/**
	 * @var array
	 */
	private $options;

	/**
	 * @var string
	 */
	private $providerKey = 'main';

	/**
	 * LoginSuccessHandler constructor.
	 *
	 * @param HttpUtils              $httpUtils
	 * @param EntityManagerInterface $entityManager
	 * @param TokenStorageInterface  $tokenStorage
	 * @param AuthenticationUtils    $authenticationUtils
	 * @param LoggerInterface        $logger
	 * @param RouterInterface        $router
	 * @param array                  $securityRoutes
	 */
	public function __construct(HttpUtils $httpUtils, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, AuthenticationUtils $authenticationUtils, LoggerInterface $logger, RouterInterface $router)
	{
		$this->httpUtils           = $httpUtils;
		$this->entityManager       = $entityManager;
		$this->tokenStorage        = $tokenStorage;
		$this->authenticationUtils = $authenticationUtils;
		$this->logger              = $logger;
		$this->router              = $router;
	}

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
		$user = $this->tokenStorage->getToken()->getUser();

		$ip      = $request->server->get('REMOTE_ADDR');

		$now     = new \DateTime('now');

		if ($user->getFailCount() > 0)
        {
            $user->setFailCount(0);
            $this->logger->notice(sprintf('The fail count for UserProvider #%s (%s) was reset after successful authentication.',$user->getId(),$user->getEmail()));
        }

		$user->setlastTimestamp($now);
		$user->setLastIPAddress($ip);

		$this->entityManager->persist($user);
		$this->entityManager->flush();

		if (null !== $user->getLocale())
			$request->setLocale($user->getLocale());

		$this->logger->notice(sprintf("Log In: UserProvider #%s (%s)",$user->getId(),$user->getEmail()));

		return $this->httpUtils->createRedirectResponse($request, $this->determineTargetUrl($request));
	}

	/**
	 * Builds the target URL according to the defined options.
	 *
	 * @return string
	 */
	protected function determineTargetUrl(Request $request)
	{
		if ($this->options['always_use_default_target_path']) {
			return $this->options['default_target_path'];
		}

		if ($targetUrl = ParameterBagUtils::getRequestParameterValue($request, $this->options['target_path_parameter'])) {
			return $targetUrl;
		}

		if (null !== $this->providerKey && $targetUrl = $this->getTargetPath($request->getSession(), $this->providerKey)) {
			$this->removeTargetPath($request->getSession(), $this->providerKey);

			return $targetUrl;
		}

		if ($this->options['use_referer'] && $targetUrl = $request->headers->get('Referer')) {
			if (false !== $pos = strpos($targetUrl, '?')) {
				$targetUrl = substr($targetUrl, 0, $pos);
			}
			if ($targetUrl && $targetUrl !== $this->httpUtils->generateUri($request, $this->options['login_path'])) {
				return $targetUrl;
			}
		}

		return $this->options['default_target_path'];
	}

	/**
	 * @param array $options
	 */
	public function setOptions(array $options)
	{
		$this->options = $options;
	}

	/**
	 * @param $providerKey
	 */
	public function setProviderKey($providerKey)
	{
		$this->providerKey = $providerKey;
	}
}
