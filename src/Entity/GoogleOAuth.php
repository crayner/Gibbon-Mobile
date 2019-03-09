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
 * Time: 15:18
 */

namespace App\Entity;


use Symfony\Component\HttpFoundation\File\File;

class GoogleOAuth
{
    /**
     * @var string|null
     */
    private $clientSecret;

    /**
     * @return string|null
     */
    public function getClientSecret(): ?string
    {
        return $this->clientSecret;
    }

    /**
     * @param string|null $clientSecret
     * @return GoogleOAuth
     */
    public function setClientSecret(?string $clientSecret): GoogleOAuth
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @var string|null
     */
    private $APIKey;

    /**
     * @return string|null
     */
    public function getAPIKey(): ?string
    {
        return $this->APIKey;
    }

    /**
     * @param string|null $APIKey
     * @return GoogleOAuth
     */
    public function setAPIKey(?string $APIKey): GoogleOAuth
    {
        $this->APIKey = $APIKey;
        return $this;
    }

    /**
     * @var string|null
     */
    private $schoolCalendar;

    /**
     * @return string|null
     */
    public function getSchoolCalendar(): ?string
    {
        return $this->schoolCalendar;
    }

    /**
     * @param string|null $schoolCalendar
     * @return GoogleOAuth
     */
    public function setSchoolCalendar(?string $schoolCalendar): GoogleOAuth
    {
        $this->schoolCalendar = $schoolCalendar;
        return $this;
    }
}