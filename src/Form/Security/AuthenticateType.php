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
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 15:34
 */
namespace App\Form\Security;

use App\Entity\Person;
use Hillrange\Form\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class AuthenticateType
 * @package App\Form\Security
 */
class AuthenticateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Username or email',
                        'autocomplete' => 'username',
                    ],
                    'label' => 'Username or email',
                    'constraints' => [
                        new Length(['max' => 75]),
                        new NotBlank(),
                    ],
                ]
            )->add('_password', PasswordType::class,
                [
                    'attr' => [
                        'placeholder' => 'Password',
                        'autocomplete' => 'current-password',
                    ],
                    'label' => 'Password',
                    'constraints' => [
                        new Length(['max' => 30]),
                        new NotBlank(),
                    ],
                ]
            );
    }

    /**
     * getBlockPrefix
     *
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'authenticate';
    }

    /**
     * configureOptions
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'translation' => 'messages',
                'data_class' => Person::class,
                'attr' => [
                    'novalidate' => true,
                    'id' => $this->getBlockPrefix(),
                ],
            ]
        );
    }
}