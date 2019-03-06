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
 * Time: 13:24
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LocaleController
 * @package App\Controller
 */
class LocaleController extends AbstractController
{
    /**
     * home
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function home()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * ntp
     * @param Request $request
     * @return JsonResponse
     */
    public function ntp(Request $request)
    {
        return new JsonResponse([
            'data' => (string) round($request->server->get('REQUEST_TIME_FLOAT')* 1000),
        ], 200);
    }
}