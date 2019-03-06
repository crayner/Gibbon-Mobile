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
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Twig\Extension;

use App\Manager\FormValidatorManager;
use Twig\Extension\AbstractExtension;

class FormValidatorExtension extends AbstractExtension
{
    /**
     * @var FormValidatorManager
     */
    private $manager;

    /**
     * @return string
     */
    public function getName()
    {
        return 'form_validator_extension';
    }

    /**
     * FormValidatorExtension constructor.
     * @param FormValidatorManager $manager
     */
    public function __construct(FormValidatorManager $manager)
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
            new \Twig_SimpleFunction('renderValidatorScript', array($this->manager, 'renderValidatorScript'), ['is_safe' => ['html']]),
        ];
    }

}