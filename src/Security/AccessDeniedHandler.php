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
 * User: craig
 * Date: 22/12/2018
 * Time: 05:59
 */
namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AccessDeniedHandler
 * @package App\Security
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * AccessDeniedHandler constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        // If Route is api_*
        if (strpos($request->get('_route'), 'api_') === 0){
            return new JsonResponse(
                [
                    'error' => $this->translator->trans('Your request failed because you do not have access to this action.'),
                ],
                200);
        }

        $request->getSession()->getFlashBag()->add('notice', 'Your request failed because you do not have access to this action.');
        return new RedirectResponse('/' . $request->get('_locale') . '/');
    }
}