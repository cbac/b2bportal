<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 * @ApiResource
 */
class Partenaire extends Client
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Metier")
     */
    private $metiers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="partenaire")
     */
    private $prestations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Catalogue", mappedBy="partenaire", orphanRemoval=true)
     */
    private $catalogues;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeEvenement", inversedBy="partenaire")
     */
    private $typeEvenement;

    public function __construct()
    {
        $this->metiers = new ArrayCollection();
        $this->typesPrestation = new ArrayCollection();
        $this->prestations = new ArrayCollection();
        $this->catalogues = new ArrayCollection();
    }

    /**
     * @return Collection|Metier[]
     */
    public function getMetiers(): Collection
    {
        return $this->metiers;
    }

    public function addMetier(Metier $metier): self
    {
        if (!$this->metiers->contains($metier)) {
            $this->metiers->add($metier);
        }

        return $this;
    }

    public function removeMetier(Metier $metier): self
    {
        if ($this->metiers->contains($metier)) {
            $this->metiers->removeElement($metier);
        }

        return $this;
    }

    /**
     * @return Collection|TypePrestation[]
     */
    public function getTypesPrestation(): Collection
    {
        return $this->typesPrestation;
    }

    public function addTypesPrestation(TypePrestation $typesPrestation): self
    {
        if (!$this->typesPrestation->contains($typesPrestation)) {
            $this->typesPrestation->add($typesPrestation);
            $typesPrestation->setPartenaire($this);
        }

        return $this;
    }

    public function removeTypesPrestation(TypePrestation $typesPrestation): self
    {
        if ($this->typesPrestation->contains($typesPrestation)) {
            $this->typesPrestation->removeElement($typesPrestation);
            // set the owning side to null (unless already changed)
            if ($typesPrestation->getPartenaire() === $this) {
                $typesPrestation->setPartenaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Prestation[]
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestation $prestation): self
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations->add($prestation);
            $prestation->setPartenaire($this);
        }

        return $this;
    }

    public function removePrestation(Prestation $prestation): self
    {
        if ($this->prestations->contains($prestation)) {
            $this->prestations->removeElement($prestation);
            // set the owning side to null (unless already changed)
            if ($prestation->getPartenaire() === $this) {
                $prestation->setPartenaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Catalogue[]
     */
    public function getCatalogues(): Collection
    {
        return $this->catalogues;
    }

    public function addCatalogue(Catalogue $catalogue): self
    {
        if (!$this->catalogues->contains($catalogue)) {
            $this->catalogues[] = $catalogue;
            $catalogue->setPartenaire($this);
        }

        return $this;
    }

    public function removeCatalogue(Catalogue $catalogue): self
    {
        if ($this->catalogues->contains($catalogue)) {
            $this->catalogues->removeElement($catalogue);
            // set the owning side to null (unless already changed)
            if ($catalogue->getPartenaire() === $this) {
                $catalogue->setPartenaire(null);
            }
        }

        return $this;
    }

    public function getTypeEvenement(): ?TypeEvenement
    {
        return $this->typeEvenement;
    }

    public function setTypeEvenement(?TypeEvenement $typeEvenement): self
    {
        $this->typeEvenement = $typeEvenement;

        return $this;
    }

}
