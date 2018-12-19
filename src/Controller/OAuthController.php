<?php
namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OAuthController extends AbstractController
{
    /**
     * connectGoogle
     * @param ClientRegistry $registry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/google/connect/", name="google_oauth")
     */
	public function connectGoogle(ClientRegistry $registry)
	{
		// will redirect to Google!
		return $registry
			->getClient('google') // key used in config.yml
			->redirect();
	}

	/**
	 * After going to Google, you're redirected back here
	 * because this is the "redirect_route" you configured
	 * in config.yml
	 *
	 * @Route("/security/oauth2callback/", name="connect_google_check")
	 */
	public function connectCheckGoogle(Request $request)
	{
	}
}
