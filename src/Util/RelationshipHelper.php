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
 * Date: 12/12/2018
 * Time: 10:22
 */
namespace App\Util;

use App\Provider\FamilyAdultProvider;
use App\Provider\FamilyChildProvider;
use App\Provider\FamilyProvider;

/**
 * Class RelationshipHelper
 * @package App\Util
 */
class RelationshipHelper
{
    /**
     * @var FamilyProvider
     */
    private static $familyProvider;

    /**
     * @var FamilyAdultProvider
     */
    private static $familyAdultProvider;

    /**
     * @var FamilyChildProvider
     */
    private static $familyChildProvider;

    /**
     * UserHelper constructor.
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(FamilyProvider $familyProvider, FamilyAdultProvider $familyAdultProvider, FamilyChildProvider $familyChildProvider)
    {
        self::$familyProvider = $familyProvider;
        self::$familyAdultProvider = $familyAdultProvider;
        self::$familyChildProvider = $familyChildProvider;
    }

    /**
     * getChildren
     * @return array
     */
    public function getChildren(): array
    {
        if (! UserHelper::isParent())
            return [];

        return self::$familyChildProvider->getChildrenFromParent(UserHelper::getCurrentUser());
    }
}