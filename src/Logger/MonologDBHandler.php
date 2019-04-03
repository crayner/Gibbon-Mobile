<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 24/12/2018
 * Time: 16:14
 */
namespace App\Logger;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Class MonologDBHandler
 * @package App\Logger
 */
class MonologDBHandler extends AbstractProcessingHandler
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @var string
     */
    private $channel = 'gibbon';

    /**
     * MonologDBHandler constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct(Logger::DEBUG, false);
        $this->em = $em;
    }

    protected function write(array $record)
    {
        if (!$this->initialized) {
            $this->initialize();
        }

        if ($this->channel != $record['channel']) {
            return;
        }

        $log = new Log();
//        $log->setMessage($record['message']);
  //      $log->setLevel($record['level_name']);

    //    $this->em->persist($log);
      //  $this->em->flush();
    }

    /**
     * initialize
     */
    private function initialize()
    {
        $this->initialized = true;
    }
}
