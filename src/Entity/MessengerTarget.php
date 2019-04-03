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

use App\Manager\EntityInterface;
use App\Manager\Traits\BooleanList;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MessengerTarget
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MessengerTargetRepository")
 * @ORM\Table(name="MessengerTarget")
 */
class MessengerTarget implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonMessengerTargetID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Messenger|null
     * @ORM\ManyToOne(targetEntity="Messenger", inversedBy="targets")
     * @ORM\JoinColumn(name="gibbonMessengerID", referencedColumnName="gibbonMessengerID", nullable=false)
     */
    private $messenger;

    /**
     * @var string|null
     * @ORM\Column(length=16, nullable=true)
     */
    private $type;

    /**
     * @var array
     */
    private static $typeList = ['Class','Course','Roll Group','Year Group','Activity','Role','Applicants','Individuals','Houses','Role Category','Transport','Attendance','Group'];

    /**
     * @var string|null
     * @ORM\Column(length=30, name="id")
     */
    private $identifier;

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $parents = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $students = 'N';

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "N"})
     */
    private $staff = 'N';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return MessengerTarget
     */
    public function setId(?int $id): MessengerTarget
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Messenger|null
     */
    public function getMessenger(): ?Messenger
    {
        return $this->messenger;
    }

    /**
     * @param Messenger|null $messenger
     * @return MessengerTarget
     */
    public function setMessenger(?Messenger $messenger, bool $add = true): MessengerTarget
    {
        if ($messenger instanceof Messenger && $add)
            $messenger->addTarget($this, false);

        $this->messenger = $messenger;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return MessengerTarget
     */
    public function setType(?string $type): MessengerTarget
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : null ;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * @param string|null $identifier
     * @return MessengerTarget
     */
    public function setIdentifier(?string $identifier): MessengerTarget
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParents(): ?string
    {
        return $this->parents;
    }

    /**
     * @param string|null $parents
     * @return MessengerTarget
     */
    public function setParents(?string $parents): MessengerTarget
    {
        $this->parents = self::checkBoolean($parents, 'N');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStudents(): ?string
    {
        return $this->students;
    }

    /**
     * @param string|null $students
     * @return MessengerTarget
     */
    public function setStudents(?string $students): MessengerTarget
    {
        $this->students = self::checkBoolean($students, 'N');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStaff(): ?string
    {
        return $this->staff;
    }

    /**
     * @param string|null $staff
     * @return MessengerTarget
     */
    public function setStaff(?string $staff): MessengerTarget
    {
        $this->staff = self::checkBoolean($staff, 'N');
        return $this;
    }

    /**
     * @return array
     */
    public static function getTypeList(): array
    {
        return self::$typeList;
    }
}