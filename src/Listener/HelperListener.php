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
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Listener;

use App\Util\EntityHelper;
use App\Util\FormatHelper;
use App\Util\RelationshipHelper;
use App\Util\SchoolYearHelper;
use App\Util\SecurityHelper;
use App\Util\UserHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class HelperListener
 *
 * This class simply pre loads static helpers.
 *
 * @package App\Listener
 */
class HelperListener implements EventSubscriberInterface
{
    /**
     * HelperListener constructor.
     * @param EntityHelper $helper
     * @param UserHelper $userHelper
     * @param RelationshipHelper $relationshipHelper
     * @param SchoolYearHelper $schoolYearHelper
     * @param FormatHelper $formatHelper
     * @param SecurityHelper $securityHelper
     */
    public function __construct(
        EntityHelper $helper,
        UserHelper $userHelper,
        RelationshipHelper $relationshipHelper,
        SchoolYearHelper $schoolYearHelper,
        FormatHelper $formatHelper,
        SecurityHelper $securityHelper
    ){}

    /**
     * getSubscribedEvents
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $listeners = [
            KernelEvents::REQUEST => 'doNothing',
        ];

        return $listeners;
    }

    /**
     * doNothing
     */
    public function doNothing(){}
}