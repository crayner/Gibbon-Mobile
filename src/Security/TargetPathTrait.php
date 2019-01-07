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
 * Date: 7/01/2019
 * Time: 08:25
 */
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Trait to get (and set) the URL the user last visited before being forced to authenticate.
 */
trait TargetPathTrait
{
    /**
     * Sets the target path the user should be redirected to after authentication.
     *
     * Usually, you do not need to set this directly.
     *
     * @param SessionInterface $session
     * @param string           $providerKey The name of your firewall
     * @param string           $uri         The URI to set as the target path
     */
    private function saveTargetPath(SessionInterface $session, $providerKey, $uri)
    {
        $session->set('_security.'.$providerKey.'.target_path', $uri);
    }

    /**
     * Returns the URL (if any) the user visited that forced them to login.
     *
     * @param SessionInterface $session
     * @param string           $providerKey The name of your firewall
     *
     * @return string
     */
    private function getTargetPath(Request $request, $providerKey)
    {
        $session = $request->getSession();
        $path =  $session->get('_security.'.$providerKey.'.target_path');
        if ($request->getContentType() === 'json') {
            return $path;
        }
        if (strpos($path, 'api_') === 0)
            $path = '';
        if (strpos($path, '_') === 0)
            $path = '';
        return $path;
    }

    /**
     * Removes the target path from the session.
     *
     * @param SessionInterface $session
     * @param string           $providerKey The name of your firewall
     */
    private function removeTargetPath(SessionInterface $session, $providerKey)
    {
        $session->remove('_security.'.$providerKey.'.target_path');
    }
}
