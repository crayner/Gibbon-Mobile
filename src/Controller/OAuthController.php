<?php
namespace App\Controller;

use App\Security\GoogleAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OAuthController extends AbstractController
{
    /**
     * connectGoogle
     * @param GoogleAuthenticator $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Google_Exception
     * @Route("/google/connect/", name="google_oauth")
     */
	public function connectGoogle(GoogleAuthenticator $manager)
	{
	    return $this->redirect($manager->connectUrl());
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
