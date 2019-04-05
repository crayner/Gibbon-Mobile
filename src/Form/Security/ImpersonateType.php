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
 * Date: 5/04/2019
 * Time: 13:21
 */
namespace App\Form\Security;

use App\Entity\Person;
use App\Manager\ImpersonationManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ImpersonateType
 * @package App\Form\Security
 */
class ImpersonateType extends AbstractType
{
    /**
     * buildForm
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('staff', EntityType::class,
                [
                    'attr' => [
                        'onChange' => 'this.form.submit()',
                    ],
                    'label' => 'Select to Impersonate',
                    'class' => Person::class,
                    'choice_label' => 'fullName',
                    'placeholder' => 'Select a Staff Member',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->where('p.status = :status')
                            ->andWhere('r.category = :category')
                            ->leftJoin('p.primaryRole', 'r')
                            ->setParameter('status', 'Full')
                            ->setParameter('category', 'staff')
                            ->orderBy('r.category', 'DESC')
                            ->addOrderBy('p.surname')
                            ->addOrderBy('p.firstName')
                            ;
                    },
                ]
            )
            ->add('student', EntityType::class,
                [
                    'attr' => [
                        'onChange' => 'this.form.submit()',
                    ],
                    'label' => 'Select to Impersonate',
                    'class' => Person::class,
                    'choice_label' => 'fullName',
                    'placeholder' => 'Select a Student',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->where('p.status = :status')
                            ->andWhere('r.category = :category')
                            ->leftJoin('p.primaryRole', 'r')
                            ->setParameter('status', 'Full')
                            ->setParameter('category', 'student')
                            ->orderBy('r.category', 'DESC')
                            ->addOrderBy('p.surname')
                            ->addOrderBy('p.firstName')
                            ;
                    },
                ]
            )
            ->add('parent', EntityType::class,
                [
                    'attr' => [
                        'onChange' => 'this.form.submit()',
                    ],
                    'label' => 'Select to Impersonate',
                    'class' => Person::class,
                    'choice_label' => 'fullName',
                    'placeholder' => 'Select a Parent',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->where('p.status = :status')
                            ->andWhere('r.category = :category')
                            ->leftJoin('p.primaryRole', 'r')
                            ->setParameter('status', 'Full')
                            ->setParameter('category', 'parent')
                            ->orderBy('r.category', 'DESC')
                            ->addOrderBy('p.surname')
                            ->addOrderBy('p.firstName')
                            ;
                    },
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
        return 'impersonate_select';
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
                'translation_domain' => 'mobile',
                'data_class' => ImpersonationManager::class,
                'attr' => [
                    'novalidate' => true,
                    'id' => $this->getBlockPrefix(),
                ],
            ]
        );
    }
}
