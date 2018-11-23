<?php
/**
 * Created by PhpStorm.
 *
 * This file is part of the Busybee Project.
 *
 * (c) Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * User: craig
 * Date: 23/11/2018
 * Time: 11:12
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SchoolYear
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SchoolYearRepository")
 * @ORM\Table(name="SchoolYear")
 */
class SchoolYear
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonSchoolYearID", columnDefinition="INT(3) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

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
}