<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 8/12/2018
 * Time: 13:26
 */
namespace App\Twig\Extension;

use App\Manager\NotificationTrayManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class NotificationTrayExtension
 * @package App\Twig\Extension
 */
class NotificationTrayExtension extends AbstractExtension
{
    /**
     * @var NotificationTrayManager
     */
    private $manager;

    /**
     * @return string
     */
    public function getName()
    {
        return 'notification_tray_extension';
    }

    /**
     * NotificationTrayExtension constructor.
     * @param NotificationTrayManager $manager
     */
    public function __construct(NotificationTrayManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * getFunctions
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('getNotificationTray', [$this->manager, 'getNotificationTrayProperties'], ['is_safe' => ['html']]),
        ];
    }
}