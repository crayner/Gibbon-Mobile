<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 20/02/2019
 * Time: 08:37
 */
namespace App\Controller;

use App\Logger\LoggerFactory;
use App\Manager\InstallationManager;
use App\Provider\SettingProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InstallationController
 * @package App\Controller
 */
class InstallationController extends AbstractController
{
    /**
     * createParameters
     * @param InstallationManager $manager
     * @param KernelInterface $kernel
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/install/first-step/", name="install_first_step")
     */
    public function createParameters(InstallationManager $manager, KernelInterface $kernel, SettingProvider $settingManager, LoggerFactory $loggerFactory)
    {
        $manager->setKernel($kernel)
            ->setSettingManager($settingManager)
            ->setLogger($loggerFactory->getLogger('setting'));

        return $this->render('Install/first_step.html.twig',
            [
                'output' => explode("\r\n", $manager->writeParametersFile()),
                'manager' => $manager,
            ]
        );
    }

    /**
     * createSettings
     * @param InstallationManager $manager
     * @param KernelInterface $kernel
     * @param SettingProvider $settingManager
     * @param LoggerFactory $loggerFactory
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/install/second-step/", name="install_second_step")
     */
    public function createSettings(InstallationManager $manager, KernelInterface $kernel, SettingProvider $settingManager, LoggerFactory $loggerFactory)
    {
        $manager->setKernel($kernel)
            ->setSettingManager($settingManager)
            ->setLogger($loggerFactory->getLogger('setting'))->settings();

        return $this->render('Install/second_step.html.twig',
            [
                'messages' => $manager->getMessageManager(),
                'manager' => $manager,
            ]
        );
    }

    /**
     * createTranslation
     * @param InstallationManager $manager
     * @param KernelInterface $kernel
     * @param SettingProvider $settingManager
     * @param LoggerFactory $loggerFactory
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/install/third-step/", name="install_third_step")
     */
    public function createTranslation(InstallationManager $manager, KernelInterface $kernel, SettingProvider $settingManager, LoggerFactory $loggerFactory)
    {
        $manager->setKernel($kernel)
            ->setSettingManager($settingManager)
            ->setLogger($loggerFactory->getLogger('setting'))->translations();
        $manager->assetsinstall();

        return $this->render('Install/second_step.html.twig',
            [
                'messages' => $manager->getMessageManager(),
                'manager' => $manager,
            ]
        );
    }
}