<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 19/12/2018
 * Time: 12:17
 */
namespace App\Util;

use App\Entity\Module;
use App\Entity\Person;
use App\Provider\ActionProvider;
use App\Provider\ModuleProvider;
use Doctrine\DBAL\Driver\PDOException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityHelper
{
    /**
     * @var ActionProvider
     */
    private static $actionProvider;

    /**
     * @var ModuleProvider
     */
    private static $moduleProvider;

    /**
     * @var LoggerInterface
     */
    private static $logger;

    /**
     * @var AuthorizationCheckerInterface
     */
    private static $checker;

    /**
     * SecurityHelper constructor.
     * @param ActionProvider $actionProvider
     * @param ModuleProvider $moduleProvider
     * @param LoggerInterface $logger
     * @param AuthorizationCheckerInterface $checker
     */
    public function __construct(
        ActionProvider $actionProvider,
        ModuleProvider $moduleProvider,
        LoggerInterface $logger,
        AuthorizationCheckerInterface $checker
    ) {
        self::$actionProvider = $actionProvider;
        self::$moduleProvider = $moduleProvider;
        self::$logger = $logger;
        self::$checker = $checker;
    }

    /**
     * @return ActionProvider
     */
    public static function getActionProvider(): ActionProvider
    {
        return self::$actionProvider;
    }

    /**
     * @return ModuleProvider
     */
    public static function getModuleProvider(): ModuleProvider
    {
        return self::$moduleProvider;
    }

    /**
     * getHighestGroupedAction
     * @param string $address
     * @return bool|string
     * @throws \Exception
     */
    public static function getHighestGroupedAction(string $address)
    {
        $module = self::checkModuleReady($address);
        try {
            $result =  self::getActionProvider()->getRepository()->createQueryBuilder('a')
                ->select('a.name')
                ->join('a.permissions', 'p')
                ->where('a.URLList LIKE :actionName')
                ->setParameter('actionName', '%'.self::getActionName($address).'%')
                ->andWhere('a.module = :module')
                ->setParameter('module', $module)
                ->andWhere('p.role = :currentRole')
                ->setParameter('currentRole', UserHelper::getCurrentUser()->getPrimaryRole())
                ->orderBy('a.precedence', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
            return empty($result['name']) ? false :  $result['name'];
        } catch (PDOException $e) {
        } catch (\PDOException $e) {
        }
        return false;
    }

    /**
     * checkModuleReady
     * @param string $address
     * @return bool|Module
     */
    public static function checkModuleReady(string $address)
    {
        try {
            return self::getModuleProvider()->findOneBy(['name' => self::getModuleName($address), 'active' => 'Y']);
        } catch (PDOException $e) {
        } catch (\PDOException $e) {
        }

        return false;
    }

    /**
     * getModuleName
     * @param string $address
     * @return bool|string
     */
    public static function getModuleName(string $address)
    {
        return substr(substr($address, 9), 0, strpos(substr($address, 9), '/'));
    }

    /**
     * getActionName
     * @param $address
     * @return bool|string
     */
    public static function getActionName($address)
    {
        return substr($address, (10 + strlen(self::getModuleName($address))));
    }

    /**
     * isActionAccessible
     * @param string $address
     * @param string $sub
     * @return bool
     * @throws \Exception
     */
    public static function isActionAccessible(string $address, string $sub = '%', ?LoggerInterface $logger = null): bool
    {
        $action = '';
        $module = '';
        $role = '';
        //Check user is logged in
        if (UserHelper::getCurrentUser() instanceof Person) {
            //Check user has a current role set
            if (! empty(UserHelper::getCurrentUser()->getPrimaryRole())) {
                //Check module ready
                $module = self::checkModuleReady($address);
                $action = self::getActionName($address);
                if ($module instanceof Module) {
                    //Check current role has access rights to the current action.
                    try {
                        $role = UserHelper::getCurrentUser()->getPrimaryRole();
                        if (count(self::getActionProvider()->findByURLListModuleRole(
                            [
                                'name' => "%".$action."%",
                                "module" => $module,
                                'role' => $role,
                                'sub' => $sub,
                            ]
                            )) > 0)
                                return true;
                    } catch (PDOException $e) {
                    }
                } else {
                    self::$logger->warning(sprintf('No module was linked to the address "%s"', $address));
                }
            }
        } else {
            self::$logger->debug(sprintf('The user was not valid!' ));
        }
        self::$logger->debug(sprintf('The action "%s", role "%s" and sub-action "%s" combination is not accessible.', $action, $role, $sub ));

        return false;
    }

    /**
     * @return AuthorizationCheckerInterface
     */
    public static function getChecker(): AuthorizationCheckerInterface
    {
        return self::$checker;
    }
}