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
namespace App\Repository;

use App\Entity\Messenger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class MessengerRepository
 * @package App\Repository
 */
class MessengerRepository extends ServiceEntityRepository
{
    /**
     * ApplicationFormRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Messenger::class);
    }

    public function findMatchingMessages(string $messageType, $identifier, string $showDate, string $personType)
    {
        $query = $this->getRepository()->createQueryBuilder('m')
            ->select('m, p, mt')
            ->where('m.messageWall_date1 = :date OR m.messageWall_date2 = :date OR m.messageWall_date3 = :date')
            ->leftJoin('m.targets', 'mt')
            ->leftJoin('m.person', 'p')
            ->andWhere('mt.type = :messageType')
            ->setParameter('date', $showDate)
            ->setParameter('messageType', $messageType);

        if (is_array($identifier))
        {
            $x = reset($identifier);
            if (is_int($x))
                $connectionType = Connection::PARAM_INT_ARRAY;
            else
                $connectionType = Connection::PARAM_STR_ARRAY;

            $query->andWhere('mt.identifier IN (:identifier)')
                ->setParameter('identifier', $identifier, $connectionType);

        } else
            $query->andWhere('mt.identifier = :identifier')
                ->setParameter('identifier', $identifier);

        switch($personType) {
            case 'parents':
                $query->andWhere('mt.parents = :yes')
                    ->setParameter('yes', 'Y');
                break;
            case 'staff':
                $query->andWhere('mt.staff = :yes')
                    ->setParameter('yes', 'Y');
                break;
            case 'students':
                $query->andWhere('mt.students = :yes')
                    ->setParameter('yes', 'Y');
                break;
            case 'any':
                break;
            default:
                trigger_error(sprintf('Programmer error: "%s" valid personType. Must be one of "staff", "students", "parents" or "any"', $personType), E_USER_ERROR);
        }

        return $query
            ->getQuery()
            ->getResult();
    }
}
