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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class Family
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FamilyRepository")
 * @ORM\Table(name="Family")
 */
class Family
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="integer", name="gibbonFamilyID", columnDefinition="INT(7) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=100)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=100, name="nameAddress", options={"comment": "The formal name to be used for addressing the family (e.g. Mr. & Mrs. Smith)"})
     */
    private $nameAddress;

    /**
     * @var string|null
     * @ORM\Column(type="text", name="homeAddress")
     */
    private $homeAddress;

    /**
     * @var string|null
     * @ORM\Column(name="homeAddressDistrict")
     */
    private $homeAddressDistrict;

    /**
     * @var string|null
     * @ORM\Column(name="homeAddressCountry")
     */
    private $homeAddressCountry;

    /**
     * @var string|null
     * @ORM\Column(length=12)
     */
    private $status = 'Unknown';

    /**
     * @var array
     */
    private static $statusList = ['Married','Separated','Divorced','De Facto','Other'];

    /**
     * @var string|null
     * @ORM\Column(length=30, name="languageHomePrimary")
     */
    private $languageHomePrimary;

    /**
     * @var string|null
     * @ORM\Column(length=30, name="languageHomeSecondary", nullable=true)
     */
    private $languageHomeSecondary;

    /**
     * @var string|null
     * @ORM\Column(length=50, name="familySync", nullable=true)
     */
    private $familySync;

    /**
     * @var Collection|null
     * @ORM\OneToMany(mappedBy="family", targetEntity="App\Entity\FamilyAdult")
     */
    private $adults;

    /**
     * @var Collection|null
     * @ORM\OneToMany(mappedBy="family", targetEntity="App\Entity\FamilyChild")
     */
    private $children;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Family
     */
    public function setId(?int $id): Family
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
     * @return Family
     */
    public function setName(?string $name): Family
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameAddress(): ?string
    {
        return $this->nameAddress;
    }

    /**
     * @param string|null $nameAddress
     * @return Family
     */
    public function setNameAddress(?string $nameAddress): Family
    {
        $this->nameAddress = $nameAddress;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeAddress(): ?string
    {
        return $this->homeAddress;
    }

    /**
     * @param string|null $homeAddress
     * @return Family
     */
    public function setHomeAddress(?string $homeAddress): Family
    {
        $this->homeAddress = $homeAddress;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeAddressDistrict(): ?string
    {
        return $this->homeAddressDistrict;
    }

    /**
     * @param string|null $homeAddressDistrict
     * @return Family
     */
    public function setHomeAddressDistrict(?string $homeAddressDistrict): Family
    {
        $this->homeAddressDistrict = $homeAddressDistrict;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHomeAddressCountry(): ?string
    {
        return $this->homeAddressCountry;
    }

    /**
     * @param string|null $homeAddressCountry
     * @return Family
     */
    public function setHomeAddressCountry(?string $homeAddressCountry): Family
    {
        $this->homeAddressCountry = $homeAddressCountry;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return Family
     */
    public function setStatus(?string $status): Family
    {
        $this->status = in_array($status, self::getStatusList()) ? $status : 'Unknown';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguageHomePrimary(): ?string
    {
        return $this->languageHomePrimary;
    }

    /**
     * @param string|null $languageHomePrimary
     * @return Family
     */
    public function setLanguageHomePrimary(?string $languageHomePrimary): Family
    {
        $this->languageHomePrimary = $languageHomePrimary;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguageHomeSecondary(): ?string
    {
        return $this->languageHomeSecondary;
    }

    /**
     * @param string|null $languageHomeSecondary
     * @return Family
     */
    public function setLanguageHomeSecondary(?string $languageHomeSecondary): Family
    {
        $this->languageHomeSecondary = $languageHomeSecondary;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFamilySync(): ?string
    {
        return $this->familySync;
    }

    /**
     * @param string|null $familySync
     * @return Family
     */
    public function setFamilySync(?string $familySync): Family
    {
        $this->familySync = $familySync;
        return $this;
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return self::$statusList;
    }

    /**
     * getAdults
     * @return Collection|null
     */
    public function getAdults(): ?Collection
    {
        if (empty($this->adults))
            $this->adults = new ArrayCollection();

        if ($this->adults instanceof PersistentCollection)
            $this->adults->initialize();

        return $this->adults;
    }

    /**
     * @param Collection|null $adults
     * @return Family
     */
    public function setAdults(?Collection $adults): Family
    {
        $this->adults = $adults;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getChildren(): ?Collection
    {
        if (empty($this->children))
            $this->children = new ArrayCollection();

        if ($this->children instanceof PersistentCollection)
            $this->children->initialize();

        return $this->children;
    }

    /**
     * @param Collection|null $children
     * @return Family
     */
    public function setChildren(?Collection $children): Family
    {
        $this->children = $children;
        return $this;
    }
}