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
 * Class Country
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 * @ORM\Table(name="Country")
 */
class Country
{
    /**
     * @var string|null
     * @ORM\Id()
     * @ORM\Column(length=80)
     */
    private $printable_name;

    /**
     * @var string|null
     * @ORM\Column(length=7, name="iddCountryCode")
     */
    private $iddCountryCode;
}