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
 * Class ExternalAssessmentField
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ExternalAssessmentFieldRepository")
 * @ORM\Table(name="ExternalAssessmentField", indexes={@ORM\Index(name="gibbonExternalAssessmentID", columns={"gibbonExternalAssessmentID"})})
 */
class ExternalAssessmentField
{
    /**
     * @var integer|null
     * @ORM\Id()
     * @ORM\Column(type="integer", name="gibbonExternalAssessmentFieldID", columnDefinition="INT(6) UNSIGNED ZEROFILL")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var ExternalAssessment|null
     * @ORM\ManyToOne(targetEntity="ExternalAssessment")
     * @ORM\JoinColumn(name="gibbonExternalAssessmentID", referencedColumnName="gibbonExternalAssessmentID", nullable=false)
     */
    private $externalAssessment;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(length=50)
     */
    private $category;

    /**
     * @var integer|null
     * @ORM\Column(type="smallint", columnDefinition="INT(4)")
     */
    private $order;

    /**
     * @var Scale|null
     * @ORM\ManyToOne(targetEntity="Scale")
     * @ORM\JoinColumn(name="gibbonScaleID", referencedColumnName="gibbonScaleID", nullable=false)
     */
    private $scale;

    /**
     * @var string|null
     * @ORM\Column(name="gibbonYearGroupIDList", nullable=true)
     */
    private $yearGroupList;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ExternalAssessmentField
     */
    public function setId(?int $id): ExternalAssessmentField
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ExternalAssessment|null
     */
    public function getExternalAssessment(): ?ExternalAssessment
    {
        return $this->externalAssessment;
    }

    /**
     * @param ExternalAssessment|null $externalAssessment
     * @return ExternalAssessmentField
     */
    public function setExternalAssessment(?ExternalAssessment $externalAssessment): ExternalAssessmentField
    {
        $this->externalAssessment = $externalAssessment;
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
     * @return ExternalAssessmentField
     */
    public function setName(?string $name): ExternalAssessmentField
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return ExternalAssessmentField
     */
    public function setCategory(?string $category): ExternalAssessmentField
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrder(): ?int
    {
        return $this->order;
    }

    /**
     * @param int|null $order
     * @return ExternalAssessmentField
     */
    public function setOrder(?int $order): ExternalAssessmentField
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return Scale|null
     */
    public function getScale(): ?Scale
    {
        return $this->scale;
    }

    /**
     * @param Scale|null $scale
     * @return ExternalAssessmentField
     */
    public function setScale(?Scale $scale): ExternalAssessmentField
    {
        $this->scale = $scale;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getYearGroupList(): ?string
    {
        return $this->yearGroupList;
    }

    /**
     * @param string|null $yearGroupList
     * @return ExternalAssessmentField
     */
    public function setYearGroupList(?string $yearGroupList): ExternalAssessmentField
    {
        $this->yearGroupList = $yearGroupList;
        return $this;
    }
}