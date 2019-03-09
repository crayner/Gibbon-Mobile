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
 * Date: 23/11/2018
 * Time: 17:57
 */
namespace App\Controller;

use App\Entity\GoogleOAuth;
use App\Entity\Person;
use App\Form\Security\GoogleOAuthType;
use App\Manager\LoginManager;
use App\Form\Security\AuthenticateType;
use App\Manager\MessageManager;
use App\Provider\SettingProvider;
use App\Security\SecurityUser;
use App\Util\EntityHelper;
use Hillrange\Form\Type\FileType;
use Hillrange\Form\Util\FormManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * login
     * @param LoginManager $manager
     * @param FormManager $formManager
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/login/", name="login")
     */
    public function login(LoginManager $manager, AuthenticationUtils $authenticationUtils, EntityHelper $repository)
    {
        if ($this->getUser() instanceof UserInterface && !$this->denyAccessUnlessGranted('ROLE_USER'))
            return $this->redirectToRoute('home');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = $repository::getRepository(Person::class)->loadUserByUsername($lastUsername) ?: new Person();
        $user->setUsername($lastUsername);
        $securityUser = new SecurityUser($user);

        $form = $this->createForm(AuthenticateType::class, $securityUser);

        return $this->render('Security\login.html.twig',
            [
                'form'      => $form->createView(),
                'manager'   => $manager,
                'fullForm'  => $form,
                'error'     => $error,
            ]
        );
    }

    /**
     * logout
     * @Route("/logout/", name="logout")
     */
    public function logout()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }

    /**
     * loadGoogleOAuth
     * @Route("/load/google/oauth/", name="load_google_oauth")
     * @IsGranted("ROLE_SYSTEM_ADMIN")
     */
    public function loadGoogleOAuth(Request $request, SettingProvider $settingProvider)
    {
        $oauth = new GoogleOAuth();
        $form = $this->createForm(GoogleOAuthType::class, $oauth);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $content = file_get_contents($oauth->getClientSecret());
            try {
                $content = json_decode($content, true);
            } catch (\Exception $e) {
                $settingProvider->getMessageManager()->add('danger', 'The Google Client Secret was not valid.', [], 'mobile');
            }
            if ($content['web'])
                $content = $content['web'];
            if (empty($content['client_id']) || empty($content['project_id']) || empty($content['client_secret']))
                $settingProvider->getMessageManager()->add('danger', 'The Google Client Secret was not valid.', [], 'mobile');
            else {
                $setting = $settingProvider->getSettingByScope('System', 'googleOAuth', true);
                $setting->setValue('Y');
                $settingProvider->saveEntity();

                $setting = $settingProvider->getSettingByScope('System', 'googleClientName', true);
                $setting->setValue($content['project_id']);
                $settingProvider->saveEntity();

                $setting = $settingProvider->getSettingByScope('System', 'googleClientID', true);
                $setting->setValue($content['client_id']);
                $settingProvider->saveEntity();

                $setting = $settingProvider->getSettingByScope('System', 'googleClientSecret', true);
                $setting->setValue($content['client_secret']);
                $settingProvider->saveEntity();

                $url = $settingProvider->getParameter('gibbon_host_url');
                foreach($content['redirect_uris'] as $item)
                {
                    if (strpos($item, $url) !== false)
                    {
                        $url = $item;
                        break;
                    }
                }
                $setting = $settingProvider->getSettingByScope('System', 'googleRedirectUri', true);
                $setting->setValue($url);
                $settingProvider->saveEntity();

                $setting = $settingProvider->getSettingByScope('System', 'googleDeveloperKey', true);
                $setting->setValue($oauth->getAPIKey());
                $settingProvider->saveEntity();

                $setting = $settingProvider->getSettingByScope('System', 'calendarFeed', true);
                $setting->setValue($oauth->getSchoolCalendar());
                $settingProvider->saveEntity();

                return $this->redirectToRoute('logout');
            }
        }

        return $this->render('Security/google_oauth.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}