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
 * Date: 8/03/2019
 * Time: 14:29
 */
namespace App\Tests\Util;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class TranslationTest
 * @package App\Tests\Util
 */
class TranslationTest extends KernelTestCase
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * setUp
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->translator = $kernel->getContainer()
            ->get('translator');
    }

    /**
     * testWelcome
     */
    public function testWelcome()
    {
        $this->translator->setDomain('gibbon');

        $this->assertEquals('Welcome', $this->translator->trans('Welcome'), 'Standard missing translation');
        $this->assertEquals('Bienvenido', $this->translator->trans('Welcome', [], null, 'es_ES'), 'Do a standard translation to Spanish');
        $this->assertEquals('Welcome', $this->translator->trans('Welcome', [], 'rubbish', 'es_ES'), 'Test with non-existant Domain to Spanish');
        $this->assertEquals('Bienvenido', $this->translator->trans('Welcome', [], 'gibbon', 'es_ES'), 'Test with named Domain to Spanish');
        $this->translator->setLocale('es_ES');
        $this->assertEquals('Bienvenido', $this->translator->trans('Welcome'), 'Locale set to es_ES then do standard translation.');
    }

    /**
     * testWelcome
     */
    public function testStringReplacement()
    {
        $this->translator->setDomain('gibbon');

        $this->assertEquals(
            'Untranslated hello world',
            # L10N: Untranslated string for string replacement.
            $this->translator->trans('Untranslated {action} {name}', [
                'action' => 'hello',
                'name' => 'world',
            ]),
            'Named string replacement works on untranslated strings'
        );

        $this->assertEquals(
            'Hello stranger from earth',
            # L10N: Untranslated string for string replacement.
            $this->translator->trans('Hello {0} from {1}', [
                'stranger',
                'earth',
            ]),
            'Translated string with un-named string replacement'
        );

        $this->assertEquals(
            'Hello stranger from earth on Tuesday',
            # L10N: Untranslated string for string replacement.
            $this->translator->trans('Hello {0} from {1} on {dayOfWeek}', [
                'stranger',
                'earth',
                'dayOfWeek' => 'Tuesday'
            ]),
            'Translated string with un-named string replacement'
        );

        $this->translator->setLocale('es_ES');

        $this->assertEquals(
            'Email (60 caracteres)',
            # L10N: Translated string for numerical replacement.
            $this->translator->trans('Email ({number} chars)', [
                '{number}' => 60,
            ]),
            'Translated string with named string replacement'
        );


        $this->translator->setLocale('en_GB');

        $this->assertEquals(
            'No files removed',
            # L10N: Translated string for numerical replacement.
            $this->translator->trans('%count% files removed', [
                '%count%' => 0,
            ]),
            'Pluralisation Test for no files.'
        );

        $this->assertEquals(
            'One file removed',
            # L10N: Translated string for numerical replacement.
            $this->translator->trans('%count% files removed', [
                '%count%' => 1,
            ]),
            'Pluralisation Test for one file.'
        );

        $this->assertEquals(
            '3 files removed',
            # L10N: Translated string for numerical replacement.
            $this->translator->trans('%count% files removed', [
                '%count%' => 3,
            ]),
            'Pluralisation Test for 3 files'
        );

        $this->translator->setLocale('es_ES');
        $this->assertEquals(
            'I have an orange',
            # L10N: Untranslated plural string with string placeholder
            $this->translator->transPlural('I have an orange', 'I have {num} oranges', 1, [
                'num' => 1,
            ]),
            'Untranslated plural string with string placeholder, with n=1'
        );

        $this->assertEquals(
            'I have 3 oranges',
            # L10N: Untranslated plural string with string placeholder
            $this->translator->transPlural('I have an orange', 'I have {num} oranges', 3, [
                'num' => 3,
            ]),
            'Untranslated plural string with string placeholder, with n=3'
        );

        $this->assertEquals(
            'Yo quiero una manzana',
            # L10N: Translated plural string with string placeholder
            $this->translator->transPlural('I have an apple', 'I have {num} apples', 1, [
                'num' => 1,
            ]),
            'Translated plural string with string placeholder, with n=1'
        );

        $this->assertEquals(
            'Yo quiero 3 manzanas',
            # L10N: Translated plural string with string placeholder
            $this->translator->transPlural('I have an apple', 'I have {num} apples', 3, [
                'num' => 3,
            ]),
            'Translated plural string with string placeholder, with n=3'
        );
    }

    /**
     * tearDown
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->translator->setDomain(null);
        $this->translator = null; // avoid memory leaks
    }
}
