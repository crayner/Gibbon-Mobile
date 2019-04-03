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
 * Class ApplicationFormFile
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationFormFileRepository")
 * @ORM\Table(name="ApplicationFormFile")
 */
class ApplicationFormFile
{
    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\Column(type="bigint", name="gibbonApplicationFormFileID", columnDefinition="INT(14) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Person|null
     * @ORM\ManyToOne(targetEntity="ApplicationForm")
     * @ORM\JoinColumn(name="gibbonApplicationFormID", referencedColumnName="gibbonApplicationFormID", nullable=false)
     */
    private $applicationForm;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column()
     */
    private $path;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ApplicationFormFile
     */
    public function setId(?int $id): ApplicationFormFile
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Person|null
     */
    public function getApplicationForm(): ?Person
    {
        return $this->applicationForm;
    }

    /**
     * @param Person|null $applicationForm
     * @return ApplicationFormFile
     */
    public function setApplicationForm(?Person $applicationForm): ApplicationFormFile
    {
        $this->applicationForm = $applicationForm;
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
     * @return ApplicationFormFile
     */
    public function setName(?string $name): ApplicationFormFile
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     * @return ApplicationFormFile
     */
    public function setPath(?string $path): ApplicationFormFile
    {
        $this->path = $path;
        return $this;
    }
}