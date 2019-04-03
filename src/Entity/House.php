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
 * Time: 11:03
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class House
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\HouseRepository")
 * @ORM\Table(name="House", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name","nameShort"})})
 */
class House
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="smallint", name="gibbonHouseID", columnDefinition="INT(3) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=30)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=10, name="nameShort")
     */
    private $nameShort;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $logo;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return House
     */
    public function setId(?int $id): House
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return House
     */
    public function setName(?string $name): House
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameShort(): ?string
    {
        return $this->nameShort;
    }

    /**
     * @param string|null $nameShort
     * @return House
     */
    public function setNameShort(?string $nameShort): House
    {
        $this->nameShort = $nameShort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     * @return House
     */
    public function setLogo(?string $logo): House
    {
        $this->logo = $logo;
        return $this;
    }
}