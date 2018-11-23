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
 * Time: 11:56
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class I18n
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\I18nRepository")
 * @ORM\Table(name="i18n")
 */
class I18n
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibboni18nID", columnDefinition="INT(4) UNSIGNED ZEROFILL")
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
     * @return I18n
     */
    public function setId(?int $id): I18n
    {
        $this->id = $id;
        return $this;
    }
}