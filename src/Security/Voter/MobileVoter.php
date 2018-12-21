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
namespace App\Security\Voter;

use App\Provider\ActionProvider;
use App\Util\SecurityHelper;
use Psr\Log\LoggerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Class MobileVoter
 * @package App\Security
 */
class MobileVoter implements VoterInterface
{
    /**
     * @var LoggerInterface
     */
    private static $logger;

    /**
     * MobileVoter constructor.
     * @param ActionProvider $provider
     * @param RouterInterface $router
     * @param AccessDecisionManagerInterface $decisionManager
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }
    /**
     * vote
     *
     * @param TokenInterface $token
     * @param mixed $subject
     * @param array $attributes
     * @return int
     * @throws \Exception
     */
    public function vote(TokenInterface $token, $subject, array $attributes): int
    {
        if (in_array('ROLE_ACTION', $attributes)) {
            $resolver = new OptionsResolver();
            $resolver->setDefaults([
                0 => 'You can never find this string in the action table.',
                1 => '%',
            ]);
            $subject = $resolver->resolve($subject);
            if (SecurityHelper::isActionAccessible($subject[0], $subject[1]))
                return VoterInterface::ACCESS_GRANTED;
            else {
                self::$logger->info(sprintf('The user "%s" attempted to access the action "%s" and was denied.', $token->getUser()->formatName(), $subject[0]), $subject);
                return VoterInterface::ACCESS_DENIED;
            }
        }

        return VoterInterface::ACCESS_ABSTAIN;
    }
}
