<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 27/02/2019
 * Time: 17:44
 */
namespace App\Manager;

use App\Entity\Menu;
use App\Entity\MenuItem;
use App\Provider\PersonProvider;
use App\Security\SecurityUser;
use App\Util\SecurityHelper;
use App\Util\UserHelper;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class MenuManager
 * @package App\Manager
 */
class MenuManager
{
    /**
     * @var Menu
     */
    private $menu;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var PersonProvider
     */
    private $personProvider;

    /**
     * MenuManager constructor.
     */
    public function __construct(TranslatorInterface $translator, RouterInterface $router, PersonProvider $personProvider)
    {
        $this->menu = new Menu();

        $this->translator = $translator;
        $this->router = $router;
        $this->personProvider = $personProvider;
    }

    /**
     * getMenuItems
     * @param SecurityUser|null $user
     * @param array $props
     */
    public function getMenuItems(?SecurityUser $user = null, array $props = [])
    {
        if (is_null($user))
            return $this->getBlankMenu($props);

        $person = $this->getPersonProvider()->find($user->getId());

        if ($this->getPersonProvider()->isStaff())
            return $this->getStaffMenu($props);

        return json_encode([]);
    }

    /**
     * getBlankMenu
     * @param array $props
     */
    private function getBlankMenu(array $props)
    {
        $this->addHomeItem();
        $props['menu'] = $this->menu->toArray();

        return json_encode($props, 12);
    }

    /**
     * addHomeItem
     * @return MenuManager
     */
    private function addHomeItem(): MenuManager
    {
        $item = new MenuItem();
        $item->setEventKey('home')
            ->setIcon(['iconName' => 'home'])
            ->setText($this->getTranslator()->trans('Home'))
            ->setRoute($this->getRouter()->generate('home'))
        ;
        $this->menu->addItem($item);
        return $this;
    }

    /**
     * getMenu
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }

    /**
     * getTranslator
     * @return TranslatorInterface
     */
    private function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * getRouter
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    /**
     * getStaffMenu
     * @param array $props
     */
    private function getStaffMenu(array $props)
    {
        $this->addHomeItem();
        $this->addSystemAdminMenu();
        $this->addLogoutItem();
        $props['menu'] = $this->menu->toArray();

        return json_encode($props);
    }

    /**
     * addLogoutItem
     * @return MenuManager
     */
    private function addLogoutItem(): MenuManager
    {
        $item = new MenuItem();
        $item->setEventKey('logout')
            ->setIcon(['iconName' => 'sign-out-alt'])
            ->setText($this->getTranslator()->trans('Logout'))
            ->setRoute($this->getRouter()->generate('logout'))
        ;
        $this->menu->addItem($item);

        return $this;
    }

    /**
     * addLogoutItem
     * @return MenuManager
     */
    private function addSystemAdminMenu(): MenuManager
    {
        if (UserHelper::getCurrentUser()->isSystemAdmin()) {
            $item = MenuItem::createItem('Admin')
                ->setIcon(['iconName' => 'tools'])
                ->setText($this->getTranslator()->trans('Admin'))
                ->addItem(
                    MenuItem::createItem('admin-google-setup')
                        ->setText($this->getTranslator()->trans('Google Integration'))
                        ->setRoute($this->getRouter()->generate('load_google_oauth'))
                )
                ->addItem(
                    MenuItem::createItem('admin-impersonation')
                        ->setText($this->getTranslator()->trans('Impersonation', [], 'mobile'))
                        ->setRoute($this->getRouter()->generate('impersonate')),
                    SecurityHelper::getChecker()->isGranted('ROLE_ALLOWED_TO_SWITCH')
                )
                ->addItem(
                    MenuItem::createItem('admin-exit_impersonation')
                        ->setText($this->getTranslator()->trans('Exit Impersonation', [], 'mobile'))
                        ->setRoute($this->getRouter()->generate('home', ['_switch_user' => 'exit'])),
                    SecurityHelper::getChecker()->isGranted('ROLE_PREVIOUS_ADMIN')
                )
            ;

            $this->menu->addItem($item);
        }
        return $this;
    }

    /**
     * getPersonProvider
     * @return PersonProvider
     */
    public function getPersonProvider(): PersonProvider
    {
        return $this->personProvider;
    }
}