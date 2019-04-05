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

use App\Manager\MenuManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class MenuExtension
 * @package App\Twig\Extension
 */
class MenuExtension extends AbstractExtension
{
    /**
     * @var MenuManager
     */
    private $manager;

    /**
     * @return string
     */
    public function getName()
    {
        return 'menu_extension';
    }

    /**
     * MenuExtension constructor.
     * @param MenuManager $manager
     */
    public function __construct(MenuManager $manager)
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
            new TwigFunction('getMenuItems', [$this->manager, 'getMenuItems'], ['is_safe' => ['html']]),
        ];
    }
}