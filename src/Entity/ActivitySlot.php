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
 * Class ActivitySlot
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ActivitySlotRepository")
 * @ORM\Table(name="ActivitySlot")
 */
class ActivitySlot
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonActivitySlotID", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Activity|null
     * @ORM\ManyToOne(targetEntity="Activity")
     * @ORM\JoinColumn(name="gibbonActivityID",referencedColumnName="gibbonActivityID", nullable=false)
     */
    private $activity;

    /**
     * @var Space|null
     * @ORM\ManyToOne(targetEntity="Space")
     * @ORM\JoinColumn(name="gibbonSpaceID",referencedColumnName="gibbonSpaceID",nullable=true)
     */
    private $space;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="locationExternal")
     */
    private $locationExternal;

    /**
     * @var DaysOfWeek|null
     * @ORM\ManyToOne(targetEntity="DaysOfWeek")
     * @ORM\JoinColumn(name="gibbonDaysOfWeekID",referencedColumnName="gibbonDaysOfWeekID", nullable=false)
     */
    private $dayOfWeek;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time",name="timeStart")
     */
    private $timeStart;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time",name="timeEnd")
     */
    private $timeEnd;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ActivitySlot
     */
    public function setId(?int $id): ActivitySlot
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return ActivitySlot
     */
    public function setActivity(?Activity $activity): ActivitySlot
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @return Space|null
     */
    public function getSpace(): ?Space
    {
        return $this->space;
    }

    /**
     * @param Space|null $space
     * @return ActivitySlot
     */
    public function setSpace(?Space $space): ActivitySlot
    {
        $this->space = $space;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocationExternal(): ?string
    {
        return $this->locationExternal;
    }

    /**
     * @param string|null $locationExternal
     * @return ActivitySlot
     */
    public function setLocationExternal(?string $locationExternal): ActivitySlot
    {
        $this->locationExternal = mb_substr($locationExternal,0,50);
        return $this;
    }

    /**
     * @return DaysOfWeek|null
     */
    public function getDayOfWeek(): ?DaysOfWeek
    {
        return $this->dayOfWeek;
    }

    /**
     * @param DaysOfWeek|null $dayOfWeek
     * @return ActivitySlot
     */
    public function setDayOfWeek(?DaysOfWeek $dayOfWeek): ActivitySlot
    {
        $this->dayOfWeek = $dayOfWeek;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimeStart(): ?\DateTime
    {
        return $this->timeStart;
    }

    /**
     * @param \DateTime|null $timeStart
     * @return ActivitySlot
     */
    public function setTimeStart(?\DateTime $timeStart): ActivitySlot
    {
        $this->timeStart = $timeStart;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimeEnd(): ?\DateTime
    {
        return $this->timeEnd;
    }

    /**
     * @param \DateTime|null $timeEnd
     * @return ActivitySlot
     */
    public function setTimeEnd(?\DateTime $timeEnd): ActivitySlot
    {
        $this->timeEnd = $timeEnd;
        return $this;
    }
}