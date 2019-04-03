<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 11/12/2018
 * Time: 13:09
 */

namespace App\Twig\Extension;

use App\Provider\SettingProvider;
use App\Provider\I18nProvider;
use App\Provider\UsernameFormatProvider;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;

/**
 * Class FormatExtension
 * @package App\Twig\Extension
 */
class FormatExtension extends AbstractExtension
{
    /**
     * @var SettingProvider
     */
    private $manager;

    /**
     * @var UsernameFormatProvider
     */
    private $formatProvider;

    /**
     * @var I18nProvider
     */
    private $i18nProvider;

    /**
     * @var RequestStack
     */
    private $stack;

    /**
     * FormatExtension constructor.
     * @param SettingProvider $manager
     * @param UsernameFormatProvider $formatProvider
     */
    public function __construct(SettingProvider $manager, UsernameFormatProvider $formatProvider, I18nProvider $i18nProvider)
    {
        $this->manager = $manager;
        $this->formatProvider =  $formatProvider;
        $this->i18nProvider = $i18nProvider;
    }
    /**
     * getFunctions
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('dateFormat', array($this->i18nProvider, 'getDateFormatPHP')),
        ];
    }
}