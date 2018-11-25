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
 * Gibbon-Mobile
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 24/11/2018
 * Time: 08:37
 */
namespace App\Form\Manager;

use App\Manager\SettingManager;
use App\Util\LocaleHelper;
use Hillrange\Form\Util\ButtonReactInterface;
use Hillrange\Form\Util\TemplateManagerInterface;

/**
 * Class LoginTypeManager
 * @package App\Form\Manager
 */
class LoginTypeManager implements TemplateManagerInterface, ButtonReactInterface
{
    /**
     * @var SettingManager
     */
    private $settingManager;

    /**
     * LoginTypeManager constructor.
     * @param SettingManager $settingManager
     */
    public function __construct(SettingManager $settingManager)
    {
        $this->settingManager = $settingManager;
    }

    /**
     * getTranslationsDomain
     *
     * @return string
     */
    public function getTranslationDomain(): string
    {
        return 'messages';
    }

    /**
     * isLocale
     *
     * @return bool
     */
    public function isLocale(): bool
    {
        return true;
    }

    /**
     * getTargetDivision
     *
     * @return string
     */
    public function getTargetDivision(): string
    {
        return 'loginForm';
    }

    /**
     * getLocale
     *
     * @return string
     */
    public function getLocale(): string
    {
        return LocaleHelper::getLocale();
    }

    /**
     * getTemplate
     *
     * @return array
     */
    public function getTemplate(): array
    {
        return [
            'form' => [
                'url' => '/login/',
            ],
            'container' => $this->getContainer(),
        ];
    }

    /**
     * getContainer
     *
     * @return array
     */
    private function getContainer(): array
    {
        $container = [
            'panel' => $this->getPanel(),
        ];
        return $container;
    }

    /**
     * getPanel
     *
     * @return array
     */
    private function getPanel(): array
    {
        $panel = [
            'label' => 'Sign into Gibbon Mobile',
            'colour' => 'success',
            'buttons' => [
                [
                    'type' => 'save',
                ],
                [
                    'type' => 'misc',
                    'icon' => ['fab','google'],
                    'colour' => 'success',
                    'display' => 'isGoogleOAuthOn',
                ],
            ],
            'rows' => $this->getRows(),
        ];
        return $panel;
    }

    /**
     * getRows
     *
     * @return array
     */
    private function getRows(): array
    {
        $rows = [
            [
                'class' => 'row',
                'columns' => [
                    [
                        'class' => 'col-12 card',
                        'form' => ['_username' => 'row'],
                    ],
                    [
                        'class' => 'col-12 card',
                        'form' => ['_password' => 'row'],
                    ],
                ],
            ],


        ];
        return $rows;
    }

    /**
     * isGoogleOAuthOn
     * @return bool
     * @throws \Exception
     */
    public function isGoogleOAuthOn(): bool
    {
        return $this->getSettingManager()->getSettingByScope('System', 'googleOAuth') === 'Y' ? true : false ;
    }

    /**
     * @return SettingManager
     */
    public function getSettingManager(): SettingManager
    {
        return $this->settingManager;
    }
}