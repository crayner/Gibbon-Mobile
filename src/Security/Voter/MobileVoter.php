<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
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
use Symfony\Component\Security\Core\User\UserInterface;

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
                if (empty($token->getUser()) || ! $token->getUser() instanceof UserInterface)
                    self::$logger->info(sprintf('The user was not correctly authenticated to authorise for action "%s".', $subject[0]), $subject);
                else
                    self::$logger->info(sprintf('The user "%s" attempted to access the action "%s" and was denied.', $token->getUser()->formatName(), $subject[0]), $subject);
                return VoterInterface::ACCESS_DENIED;
            }
        }

        return VoterInterface::ACCESS_ABSTAIN;
    }
}
