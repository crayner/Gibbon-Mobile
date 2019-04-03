<?php
/**
 * Created by PhpStorm.
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