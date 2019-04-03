<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
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