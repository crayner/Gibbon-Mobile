<?php
/**
 * Created by PhpStorm.
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