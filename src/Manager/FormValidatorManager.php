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
namespace App\Manager;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class FormValidatorManager
 * @package App\Manager
 */
class FormValidatorManager
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * FormValidatorManager constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * renderValidatorScript
     * @param FormInterface $form
     * @return array
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderValidatorScript(FormInterface $form): string
    {
        $constraints = [];

        foreach($form->all() as $child)
        {
            $w = $this->getConstraint($child);
            if (! empty($w))
                $constraints = array_merge($constraints, $w);
        }

        $result = '{';
        foreach($constraints as $name=>$constraint)
            $result .= $name . ': ' . json_encode($constraint) . ',';

        $result = trim($result, ',') . '}';

        $x = $this->twig->render('Default/validate.html.twig', ['name' => $form->getName(), 'constraints' => $result]);

        return new \Twig_Markup($x, 'html');
    }

    /**
     * getConstraint
     * @param FormInterface $form
     * @return array
     */
    private function getConstraint(FormInterface $form): array
    {
        $config = $form->getConfig();
        $result = [];
        if (! empty($config->getOption('constraints')) || $config->getOption('required') === true)
        {
            $constraints = $config->getOption('constraints') ?: [];
            foreach($constraints as $constraint)
            {
                switch (get_class($constraint))
                {
                    case NotBlank::class:
                        $result['presence'] = true;
                        break;
                    case Length::class:
                        $x = [];
                        if(! empty($constraint->min))
                            $x['minimum'] = $constraint->min;
                        if(! empty($constraint->max))
                            $x['maximum'] = $constraint->max;
                        if(! empty($constraint->min) && $constraint->min === $constraint->max) {
                            unset($x['minimum'], $x['maximum']);
                            $x['is'] = $constraint->min;
                        }
                        if (! empty($x))
                            $result['length'] = $x;
                        break;
                    default:
                        dump(get_class($constraint));
                }
            }
            if ($config->getOption('required'))
                $result['presence'] = true;
            return [$form->createView()->vars['id'] => $result];
        }
        return $result;
    }
}