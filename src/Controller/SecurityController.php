<?php
/**
 * Created by PhpStorm.
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
use App\Form\Security\ImpersonateType;
use App\Manager\ImpersonationManager;
use App\Manager\LoginManager;
use App\Form\Security\AuthenticateType;
use App\Manager\StaffDashboardManager;
use App\Provider\SettingProvider;
use App\Security\SecurityUser;
use App\Util\EntityHelper;
use App\Util\UserHelper;
use Hillrange\Form\Util\FormManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * login
     * @param LoginManager $manager
     * @param AuthenticationUtils $authenticationUtils
     * @param EntityHelper $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/login/", name="login")
     */
    public function login(LoginManager $manager, AuthenticationUtils $authenticationUtils, EntityHelper $repository)
    {
        if ($this->getUser() instanceof UserInterface && !$this->isGranted('ROLE_USER'))
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
     * @param Request $request
     * @param SettingProvider $settingProvider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
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

    /**
     * impersonate
     * @param Request $request
     * @param ImpersonationManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/impersonate/", name="impersonate")
     * @IsGranted("ROLE_ALLOWED_TO_SWITCH")
     */
    public function impersonate(Request $request, ImpersonationManager $manager)
    {
        $form = $this->createForm(ImpersonateType::class, $manager);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('home', ['_switch_user' => $manager->getPerson()->getUsername()]);
        }
        return $this->render('Security/impersonate.html.twig',
            [
                'form' => $form->createView(),
                'fullForm' => $form,
            ]
        );
    }
}