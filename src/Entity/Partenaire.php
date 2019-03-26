<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Prestation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 * 
 */
class Partenaire extends Client
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Metier")
     */
    private $metiers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="partenaire", orphanRemoval=true)
     */
    private $prestations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Catalogue", mappedBy="partenaire", orphanRemoval=true)
     */
    private $catalogues;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypeEvenement", inversedBy="partenaires")
     */
    private $typeEvenements;

    public function __construct()
    {
        $this->metiers = new ArrayCollection();
        $this->typeEvenements = new ArrayCollection();
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

    public function addMetier(Metier $metier, EntityManager $entityManager): self
    {
        if (!$this->metiers->contains($metier)) {
            $this->metiers->add($metier);
            foreach($metier->gettypesPrestation() as $typePrestation){
                $catEntry = new Catalogue();
                $catEntry->setTypePrestation($typePrestation);
                $entityManager->persist($catEntry);
                $this->addCatalogue($catEntry);
            }
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

    public function getTypeEvenements(): ?Collection
    {
        return $this->typeEvenements;
    }

    public function addTypeEvenement(TypeEvenement $typeEvenement): self
    {
        if (!$this->typeEvenements->contains($typeEvenement)) {
            $this->typeEvenements->add($typeEvenement);
        }
        
        return $this;
    }
    
    public function removeTypeEvenement(TypeEvenement $typeEvenement): self
    {
        if ($this->typeEvenements->contains($typeEvenement)) {
            $this->typeEvenements->removeElement($typeEvenement);
        }
        
        return $this;
    }
}
