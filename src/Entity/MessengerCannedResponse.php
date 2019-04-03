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
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MessengerCannedResponse
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MessengerCannedResponseRepository")
 * @ORM\Table(name="MessengerCannedResponse")
 * @ORM\HasLifecycleCallbacks()
 */
class MessengerCannedResponse
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonMessengerCannedResponseID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $subject;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", name="timestampCreator", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $timestampCreator;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="gibbonPersonIDCreator", referencedColumnName="gibbonPersonID", nullable=false)
     */
    private $creator;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return MessengerCannedResponse
     */
    public function setId(?int $id): MessengerCannedResponse
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     * @return MessengerCannedResponse
     */
    public function setSubject(?string $subject): MessengerCannedResponse
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     * @return MessengerCannedResponse
     */
    public function setBody(?string $body): MessengerCannedResponse
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestampCreator(): ?\DateTime
    {
        return $this->timestampCreator;
    }

    /**
     * setTimestampCreator
     * @param \DateTime|null $timestampCreator
     * @return MessengerCannedResponse
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function setTimestampCreator(?\DateTime $timestampCreator = null): MessengerCannedResponse
    {
        $this->timestampCreator = $timestampCreator ?: new \DateTime('now');
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getCreator(): ?Person
    {
        return $this->creator;
    }

    /**
     * @param Person|null $creator
     * @return MessengerCannedResponse
     */
    public function setCreator(?Person $creator): MessengerCannedResponse
    {
        $this->creator = $creator;
        return $this;
    }
}