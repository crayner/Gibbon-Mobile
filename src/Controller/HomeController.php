<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 12:32
 */
namespace App\Controller;

use App\Provider\SettingProvider;
use App\Manager\StaffDashboardManager;
use App\Manager\VersionManager;
use App\Util\UserHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * home
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="home")
     * @IsGranted("ROLE_USER")
     */
    public function home(StaffDashboardManager $staffDashboardManager)
    {
        if (UserHelper::isStaff())
            $manager = $staffDashboardManager;

        return $this->render('Default/home.html.twig',
            [
                'manager' => $manager,
            ]
        );
    }

    /**
     * versionWarning
     * @param VersionManager $manager
     * @param SettingProvider $settingManager
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/version/warning/", name="_version_warning")
     */
    public function versionWarning(VersionManager $manager, SettingProvider $settingManager, TranslatorInterface $translator)
    {
        $manager->setSettingManager($settingManager);
        $manager->loadVersionInformation();
        return $this->render('Install/version_warning.html.twig',
            [
                'manager' => $manager,
                'messages' => $manager->getSettingManager()->getMessageManager()->getTranslatedMessages($translator),
            ]
        );
    }
}