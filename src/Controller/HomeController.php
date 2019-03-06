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
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 12:32
 */
namespace App\Controller;

use App\Manager\SettingManager;
use App\Manager\StaffDashboardManager;
use App\Manager\TranslationManager;
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
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/version/warning/", name="_version_warning")
     */
    public function versionWarning(VersionManager $manager, SettingManager $settingManager, TranslatorInterface $translator)
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