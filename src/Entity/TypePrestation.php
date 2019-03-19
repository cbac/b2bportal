<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypePrestationRepository")
 */
class TypePrestation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Catalogue", inversedBy="typesPrestation")
     */
    private $catalogues;

    public function __construct()
    {
        $this->initDatas();
    }
    public function __clone()
    {
        $this->initDatas();
    }
    private function initDatas(){
        $this->catalogues = new ArrayCollection();
        $this->id = null;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomType(): ?string
    {
        return $this->nomType;
    }

    public function setNomType(string $nomType): self
    {
        $this->nomType = $nomType;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCatalogues(): ?ArrayCollection
    {
        return $this->catalogues;
    }

    public function addToCatalogues(?Catalogue $catalogue): self
    {
        $this->catalogues->add($catalogue);

        return $this;
    }
    public function __toString() :string {
        return $this->nomType;
    }
}
