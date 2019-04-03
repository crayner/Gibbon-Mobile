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
 * Time: 11:43
 */
namespace App\Manager;

use App\Entity\Person;
use App\Util\UserHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class NotificationTrayManager
 * @package App\Manager
 */
class NotificationTrayManager
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @var bool
     */
    private $displayTray = false;

    /**
     * @var Request
     */
    private $stack;

    /**
     * NotificationTrayManager constructor.
     * @param TranslatorInterface $translation
     */
    public function __construct(TranslatorInterface $translator, NotificationManager $notificationManager, RequestStack $stack)
    {
        $this->translator = $translator;
        $this->notificationManager = $notificationManager;
        $this->setDisplayTray();
        $this->stack = $stack;
    }

    /**
     * getNotificationTrayProperties
     * @return array
     */
    public function getNotificationTrayProperties(): string
    {
        $result = [];

        $translations = [];
        $translations['Message Wall'] = $this->getTranslator()->trans('Message Wall', [], 'messages');
        $translations['Notifications'] = $this->getTranslator()->trans('Notifications', [], 'messages');

        $result['translations'] = $translations;

        $result['displayTray'] = $this->getDisplayTray();
        $result['locale'] = $this->getStack()->getCurrentRequest()->get('_locale');
        $result['isStaff'] = UserHelper::isStaff();

        return json_encode($result);
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @return NotificationManager
     */
    public function getNotificationManager(): NotificationManager
    {
        return $this->notificationManager;
    }

    /**
     * getDisplayTray
     * @return bool
     */
    public function getDisplayTray(): bool
    {
        return (bool) $this->displayTray;
    }

    /**
     * setDisplayTray
     * @return NotificationTrayManager
     * @throws \Exception
     */
    public function setDisplayTray(): NotificationTrayManager
    {
        $this->displayTray = UserHelper::getCurrentUser() instanceof Person;
        return $this;
    }

    /**
     * getStack
     * @return RequestStack
     */
    public function getStack(): RequestStack
    {
        return $this->stack;
    }
}