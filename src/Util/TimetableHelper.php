<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 8/01/2019
 * Time: 13:21
 */

namespace App\Util;


use App\Entity\TTDayDate;
use App\Provider\TimetableProvider;

class TimetableHelper
{
    /**
     * @var TimetableProvider
     */
    private static $provider;

    /**
     * TimetableHelper constructor.
     * @param TimetableProvider $provider
     */
    public function __construct(TimetableProvider $provider)
    {
        self::$provider = $provider;
    }

    /**
     * isSchoolOpen
     * @param \DateTime $date
     * @return bool
     * @throws \Exception
     */
    public static function isSchoolOpen(\DateTime $date): bool
    {
        return self::$provider->getRepository(TTDayDate::class)->isSchoolOpen($date);
    }
}