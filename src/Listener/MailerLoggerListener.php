<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Listener;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Class MailerLoggerListener
 * @package App\Listener
 */
class MailerLoggerListener implements \Swift_Events_SendListener
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MailerLoggerUtil constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Swift_Events_SendEvent $evt
     */
    public function beforeSendPerformed(\Swift_Events_SendEvent $evt)
    {
        // ...
    }

    /**
     * @param \Swift_Events_SendEvent $evt
     */
    public function sendPerformed(\Swift_Events_SendEvent $evt)
    {
        $level   = $this->getLogLevel($evt);
        $message = $evt->getMessage();

        $this->logger->log(
            $level,
            $message->getSubject().' - '.$message->getId(),
            [
                'result'  => $evt->getResult(),
                'subject' => $message->getSubject(),
                'to'      => $message->getTo(),
                'cc'      => $message->getCc(),
                'bcc'     => $message->getBcc(),
            ]
        );
    }


    /**
     * @param \Swift_Events_SendEvent $evt
     *
     * @return string
     */
    private function getLogLevel(\Swift_Events_SendEvent $evt): string
    {
        switch ($evt->getResult()) {
            // Sending has yet to occur
            case \Swift_Events_SendEvent::RESULT_PENDING:
                return LogLevel::DEBUG;

            // Email is spooled, ready to be sent
            case \Swift_Events_SendEvent::RESULT_SPOOLED:
                return LogLevel::DEBUG;

            // Sending failed
            default:
            case \Swift_Events_SendEvent::RESULT_FAILED:
                return LogLevel::CRITICAL;

            // Sending worked, but there were some failures
            case \Swift_Events_SendEvent::RESULT_TENTATIVE:
                return LogLevel::ERROR;

            // Sending was successful
            case \Swift_Events_SendEvent::RESULT_SUCCESS:
                return LogLevel::INFO;
        }
    }
}
