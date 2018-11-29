<?php
namespace App\Security;

use App\Manager\MessageManager;
use App\Manager\SettingManager;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use KnpU\OAuth2ClientBundle\Exception\MissingAuthorizationCodeException;
use KnpU\OAuth2ClientBundle\Security\Exception\NoAuthCodeAuthenticationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class GoogleAuthenticator implements AuthenticatorInterface
{
    use TargetPathTrait;
	/**
	 * @var ClientRegistry
	 */
	private $clientRegistry;

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * @var RouterInterface
	 */
	private $router;

	/**
	 * @var MessageManager
	 */
	private $messageManager;

	/**
	 * @var SettingManager
	 */
	private $settingManager;

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * @var Object
	 */
	private $google_user;

	/**
	 * GoogleAuthenticator constructor.
	 *
	 * @param ClientRegistry         $clientRegistry
	 * @param EntityManagerInterface $em
	 * @param RouterInterface        $router
	 */
	public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em, RouterInterface $router, MessageManager $messageManager, SettingManager $settingManager, LoggerInterface $logger)
	{
		$this->clientRegistry = $clientRegistry;
		$this->em = $em;
		$this->router = $router;
		$this->messageManager = $messageManager;
		$this->settingManager = $settingManager;
		$this->logger = $logger->withName('security');
	}

	public function getCredentials(Request $request)
	{
		$this->logger->debug("Google Authentication: Google authentication attempted.");

		return $this->fetchAccessToken($this->getGoogleClient());
	}

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
	{
		/** @var GoogleUser $googleUser */
		$this->google_user = $this->getGoogleClient()
			->fetchUserFromToken($credentials);

		// 1) have they logged in with Google before? Easy!
/*		$existingUser = $this->em->getRepository(Person::class)
			->findOneBy(['googleId' => $googleUser->getId()]);
		if ($existingUser) {
			return $existingUser;
		}
*/
		// 2) do we have a matching user by email?
		$user = $userProvider->loadUserByUsername($this->google_user->getEmail());

		// 3) Maybe you just want to "register" them by creating
		// a UserProvider object
//		$user->setGoogleId($googleUser->getId());
//		$this->em->persist($user);
//		$this->em->flush();

		return $user;
	}

	/**
	 * @return
	 */
	private function getGoogleClient()
	{
		return $this->clientRegistry
			// "google" is the key used in knpu_oauth2_client.yaml
			->getClient('google');
	}

	/**
	 * @param Request                 $request
	 * @param AuthenticationException $exception
	 *
	 * @return null|RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		$this->logger->notice("Google Authentication: ".  $exception->getMessage());

		return new RedirectResponse($this->router->generate($this->settingManager->getParameter('security.routes.security_user_login')));
	}

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return null|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{
		$user = $token->getUser();
		$this->logger->notice("Google Authentication: UserProvider #" . $user->getId() . " (" . $user->getEmail() . ") The user authenticated via Google.");


		$user->setGoogleAPIRefreshToken($this->google_user->getId());

		$this->em->persist($user);
		$this->em->flush();

		if (null !== $user->getLocale())
			$request->setLocale($user->getLocale());

        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey))
            return new RedirectResponse($targetPath);
        return new RedirectResponse($this->getLoginUrl());
	}

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
	{
		return new RedirectResponse($this->router->generate($this->settingManager->getParameter('security.routes.security_user_login')));
	}

	/**
	 * @param UserInterface $user
	 * @param string        $providerKey
	 *
	 * @return UsernamePasswordToken|\Symfony\Component\Security\Guard\Token\GuardTokenInterface
	 */
	public function createAuthenticatedToken(UserInterface $user, $providerKey)
	{
		return new UsernamePasswordToken(
			$user,
			$user->getPassword(),
			$providerKey,
			$user->getRoles()
		);
	}

	/**
	 * @param mixed         $credentials
	 * @param UserInterface $user
	 *
	 * @return bool
	 */
	public function checkCredentials($credentials, UserInterface $user)
	{
		return true;
	}

	/**
	 * @param Request $request
	 *
	 * @return bool
	 */
	public function supports(Request $request): bool
	{
		if ($request->getPathInfo() != '/security/oauth2callback/')
			return false;

		return true;
	}

	/**
	 * @param OAuth2Client $client
	 *
	 * @return \League\OAuth2\Client\Token\AccessToken
	 * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
	 */
	protected function fetchAccessToken(OAuth2Client $client)
	{
		try {
			return $client->getAccessToken();
		} catch (MissingAuthorizationCodeException $e) {
			throw new NoAuthCodeAuthenticationException();
		}
	}

	/**
	 * @return bool
	 */
	public function supportsRememberMe()
	{
		return false;
	}

    /**
     * getLoginUrl
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }
}
