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
 * Date: 2/03/2019
 * Time: 11:56
 */
namespace App\Manager;

use App\Manager\Objects\Message;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class FlashBagManager
 * @package App\Manager
 */
class FlashBagManager
{
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var MessageManager
     */
    private $messageManager;

    /**
     * FlashBagManager constructor.
     *
     * @param FlashBagInterface   $flashBag
     * @param TranslatorInterface $translator
     */
    public function __construct(FlashBagInterface $flashBag, TranslatorInterface $translator, MessageManager $messageManager)
    {
        $this->translator = $translator;
        $this->flashBag   = $flashBag;
        $this->messageManager = $messageManager;
    }

    /**
     * @param null|array $messages
     */
    public function addMessages(MessageManager $messages = null)
    {
        $messages = $messages ? $messages : $this->messageManager ;

        foreach ($messages->getMessages() as $message)
        {
            if (!$message instanceof Message)
                continue;

            $this->flashBag->add($message->getLevel(), $this->translator->trans($message->getMessage(), $message->getOptions(), $message->getDomain()));
        }

        $messages->clearMessages();
    }

    /**
     * @param MessageManager $manager
     *
     * @return string
     */
    public function renderMessages(MessageManager $manager)
    {
        $messages = '';
        foreach ($manager->getMessages() as $message)
        {
            if (!$message instanceof Message)
                continue;
            if ($message->getDomain() === false)
                $messages .= "<div class='alert-dismissible fade show alert alert-" . $message->getLevel() . "'>" . $message->getMessage() . "</div>\n";
            else
                $messages .= "<div class='alert-dismissible fade show alert alert-" . $message->getLevel() . "'>" . $this->translator->trans($message->getMessage(), $message->getOptions(), $message->getDomain()) . "</div>\n";
        }

        $manager->clearMessages();

        return $messages;
    }

    /**
     * Add Message (Synonym)
     *
     * @param string      $level
     * @param string      $message
     * @param array       $options
     * @param string|null $domain
     *
     * @return $this
     */
    public function add(string $level, string $message, array $options = [], string $domain = null)
    {
        return $this->messageManager->addMessage($level, $message, $options, $domain);
    }


    /**
     * @param string $domain
     */
    public function setDomain(string $domain): FlashBagManager
    {
        $this->messageManager->setDomain($domain);

        return $this;
    }
}
