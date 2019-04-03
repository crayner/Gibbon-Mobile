<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 11:12
 */
namespace App\Entity;

use App\Manager\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SchoolYear
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SchoolYearRepository")
 * @ORM\Table(name="SchoolYear", uniqueConstraints={@ORM\UniqueConstraint(name="academicYearName", columns={"name"}), @ORM\UniqueConstraint(name="sequenceNumber", columns={"sequenceNumber"})})
 */
class SchoolYear implements EntityInterface
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonSchoolYearID", columnDefinition="INT(3) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return SchoolYear
     */
    public function setId(?int $id): SchoolYear
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=9)
     */
    private $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return SchoolYear
     */
    public function setName(?string $name): SchoolYear
    {
        $this->name = mb_substr($name, 0,9);
        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(length=8, options={"default": "Upcoming"})
     */
    private $status = 'Upcoming';

    /**
     * @var array 
     */
    private static $statusList = ['Past', 'Current', 'Upcoming'];
    
    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * setStatus
     * @param string|null $status
     * @return SchoolYear
     */
    public function setStatus(?string $status): SchoolYear
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Unknown' ;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="firstDay", nullable=true)
     */
    private $firstDay;

    /**
     * @return \DateTime|null
     */
    public function getFirstDay(): ?\DateTime
    {
        return $this->firstDay;
    }

    /**
     * @param \DateTime|null $firstDay
     * @return SchoolYear
     */
    public function setFirstDay(?\DateTime $firstDay): SchoolYear
    {
        $this->firstDay = $firstDay;
        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", name="lastDay", nullable=true)
     */
    private $lastDay;

    /**
     * @return \DateTime|null
     */
    public function getLastDay(): ?\DateTime
    {
        return $this->lastDay;
    }

    /**
     * @param \DateTime|null $lastDay
     * @return SchoolYear
     */
    public function setLastDay(?\DateTime $lastDay): SchoolYear
    {
        $this->lastDay = $lastDay;
        return $this;
    }

    /**
     * @var integer
     * @ORM\Column(type="smallint",columnDefinition="INT(3)",name="sequenceNumber")
     */
    private $sequenceNumber;

    /**
     * @return int
     */
    public function getSequenceNumber(): int
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int $sequenceNumber
     * @return SchoolYear
     */
    public function setSequenceNumber(int $sequenceNumber): SchoolYear
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * isEqualTo
     * @param $entity
     * @return bool
     */
    public function isEqualTo($entity): bool
    {
        if ($this->getId() !== $entity->getId())
            return false;

        if ($this->getName() !== $entity->getName())
            return false;

        if ($this->getFirstDay() !== $entity->getFirstDay())
            return false;

        if ($this->getLastDay() !== $entity->getLastDay())
            return false;

        return true;
    }
}