<?php
namespace App\Security;

use App\Util\LocaleHelper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
	/**
	 * @var string
	 */
	private $locale = 'en';

	/**
	 * @var \Twig_Environment
	 */
	private $router;

    /**
     * LogoutSuccessHandler constructor.
     * @param RouterInterface $router
     * @param LocaleHelper $manager
     * @param string $locale
     */
	public function __construct(RouterInterface $router, LocaleHelper $manager, string $locale = 'en')
	{
		$this->router = $router;
        $this->locale = $locale;
	}

    /**
     * onLogoutSuccess
     *
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
	public function onLogoutSuccess(Request $request)
    {
        if ($request->hasSession())
        {
            $session = $request->getSession();
            $flash = $session->getFlashBag()->all();
            $session->invalidate();
            if (! empty($flash))
                $session->getFlashBag()->setAll($flash);
        }
		$request->setLocale($this->locale);

		return new RedirectResponse($this->router->generate('home'));
	}
}