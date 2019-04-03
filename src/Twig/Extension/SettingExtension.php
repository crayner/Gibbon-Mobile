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
 * Time: 15:27
 */
namespace App\Twig\Extension;

use App\Provider\SettingProvider;
use App\Util\VersionHelper;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Extension\AbstractExtension;

/**
 * Class SettingExtension
 * @package App\Twig\Extension
 */
class SettingExtension extends AbstractExtension
{
    /**
     * @var SettingProvider
     */
    private $manager;

    /**
     * SettingExtension constructor.
     * @param SettingProvider $manager
     */
    public function __construct(SettingProvider $manager)
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
            new \Twig_SimpleFunction('getSetting', array($this->manager, 'getSettingByScope')),
            new \Twig_SimpleFunction('getParameter', array($this->manager, 'getParameter')),
            new \Twig_SimpleFunction('getVersion', array($this, 'getVersion')),
            new \Twig_SimpleFunction('getGibbonVersion', array($this, 'getGibbonVersion')),
            new \Twig_SimpleFunction('clearCache', array($this, 'clearCache')),
        ];
    }

    /**
     * getVersion
     * @return string
     */
    public function getVersion(){
        return VersionHelper::VERSION;
    }

    /**
     * getGibbonVersion
     * @return string
     */
    public function getGibbonVersion(): string
    {
        return implode(',', VersionHelper::GIBBON);
    }

    /**
     * clearCache
     */
    public function clearCache()
    {
        $fs = new Filesystem();
        $fs->remove($this->manager->getContainer()->get('kernel')->getCacheDir());
        die();
    }
}