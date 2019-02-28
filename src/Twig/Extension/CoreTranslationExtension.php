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
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Twig\Extension;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;

/**
 * Class CoreTranslationExtension
 * @package App\Twig\Extension
 */
class CoreTranslationExtension extends AbstractExtension
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @return string
     */
    public function getName()
    {
        return 'core_translation_extension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('coreTranslations', array($this, 'getCoreTranslations')),
        ];
    }

    /**
     * CoreTranslationExtension constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * getCoreTranslations
     * @return array
     */
    public function getCoreTranslations(): array
    {
        $translations = [];
        $translations['Your session is about to expire: you will be logged out shortly.'] = $this->translator->trans('Your session is about to expire: you will be logged out shortly.');
        $translations['Logout'] = $this->translator->trans('Logout');
        $translations['Home'] = $this->translator->trans('Home');
        $translations['Menu'] = $this->translator->trans('Menu', [], 'mobile');
        $translations['Stay Connected'] = $this->translator->trans('Stay Connected');
        return $translations;
    }
}