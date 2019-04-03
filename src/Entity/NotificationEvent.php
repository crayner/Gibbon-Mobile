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
 * Class NotificationEvent
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\NotificationEventRepository")
 * @ORM\Table(name="NotificationEvent", uniqueConstraints={@ORM\UniqueConstraint(name="event", columns={"event","moduleName"})})
 * */
class NotificationEvent implements EntityInterface
{
    use BooleanList;

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonNotificationEventID", columnDefinition="INT(6) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=90)
     */
    private $event;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="moduleName")
     */
    private $moduleName;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="actionName")
     */
    private $actionName;

    /**
     * @var string|null
     * @ORM\Column(length=12, options={"default": "Core"})
     */
    private $type = 'Core';

    /**
     * @var array
     */
    private static $typeList = ['Core', 'Additional', 'CLI'];

    /**
     * @var string|null
     * @ORM\Column(options={"default": "All"})
     */
    private $scopes = 'All';

    /**
     * @var string|null
     * @ORM\Column(length=1, options={"default": "Y"})
     */
    private $active = 'Y';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return NotificationEvent
     */
    public function setId(?int $id): NotificationEvent
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEvent(): ?string
    {
        return $this->event;
    }

    /**
     * @param string|null $event
     * @return NotificationEvent
     */
    public function setEvent(?string $event): NotificationEvent
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getModuleName(): ?string
    {
        return $this->moduleName;
    }

    /**
     * @param string|null $moduleName
     * @return NotificationEvent
     */
    public function setModuleName(?string $moduleName): NotificationEvent
    {
        $this->moduleName = $moduleName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionName(): ?string
    {
        return $this->actionName;
    }

    /**
     * @param string|null $actionName
     * @return NotificationEvent
     */
    public function setActionName(?string $actionName): NotificationEvent
    {
        $this->actionName = $actionName;
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
     * @return NotificationEvent
     */
    public function setType(?string $type): NotificationEvent
    {
        $this->type = in_array($type, self::getTypeList()) ? $type : 'Core';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getScopes(): ?string
    {
        return $this->scopes;
    }

    /**
     * @param string|null $scopes
     * @return NotificationEvent
     */
    public function setScopes(?string $scopes): NotificationEvent
    {
        $this->scopes = $scopes ?: 'All';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * @param string|null $active
     * @return NotificationEvent
     */
    public function setActive(?string $active): NotificationEvent
    {
        $this->active = self::checkBoolean($active);
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