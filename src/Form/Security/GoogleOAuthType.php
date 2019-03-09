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
 * Date: 9/03/2019
 * Time: 15:14
 */
namespace App\Form\Security;

use App\Entity\GoogleOAuth;
use Hillrange\Form\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class GoogleOAuthType
 * @package App\Form\Security
 */
class GoogleOAuthType extends AbstractType
{
    /**
     * buildForm
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clientSecret', FileType::class,
                [
                    'constraints' => [
                        new File(['mimeTypes' => ['application/json', 'text/plain']]),
                    ],
                    'label' => 'Enable OAuth login via a Google Account.',
                    'translation_domain' => 'mobile',
                    'help' => 'Download the json file for your Web application available on https://console.cloud.google.com/apis/credentials'
                ]
            )
            ->add('APIKey', TextType::class,
                [
                    'label' => 'Google API Key',
                    'translation_domain' => 'mobile',
                    'help' => 'This is a 39 character key that can be created or found at https://console.cloud.google.com/apis/credentials',
                    'constraints' => [
                        new NotBlank(),
                        new Length(['max' => 39, 'min' => 39]),
                    ],
                ]
            )
            ->add('schoolCalendar', TextType::class,
                [
                    'label' => 'School Google Calendar ID',
                    'help' => 'Google Calendar ID for your school calendar. Only enables timetable integration when logging in via Google.',
                    'constraints' => [
                        new Email(),
                    ],
                ]
            )
        ;
    }

    /**
     * getBlockPrefix
     *
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'google_oauth';
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
                'data_class' => GoogleOAuth::class,
                'attr' => [
                    'id' => $this->getBlockPrefix(),
                ],
            ]
        );
    }
}