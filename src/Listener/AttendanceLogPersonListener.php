<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 17/01/2019
 * Time: 10:33
 */
namespace App\Listener;

use App\Entity\AttendanceLogPerson;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Class AttendanceLogPersonListener
 * @package App\Listener
 */
class AttendanceLogPersonListener
{
    /**
     * preUpdate
     * @param PreUpdateEventArgs $args
     * @throws \Exception
     */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        // only act on some "AttendanceLogPerson" entity
        if (! $entity instanceof AttendanceLogPerson) {
            return;
        }

        if (count($args->getEntityChangeSet()) < 2) {
            return;
        }

        $entity->setTakerTime();
    }
}