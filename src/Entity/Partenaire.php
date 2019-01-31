<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire extends Client
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Metier")
     */
    private $metiers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TypePrestation", mappedBy="partenaire")
     */
    private $typesPrestation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="partenaire")
     */
    private $prestations;

    public function __construct()
    {
        $this->metiers = new ArrayCollection();
        $this->typesPrestation = new ArrayCollection();
        $this->prestations = new ArrayCollection();
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
            $this->metiers[] = $metier;
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
            $this->typesPrestation[] = $typesPrestation;
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
            $this->prestations[] = $prestation;
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
    public function __toString() :string {
        return $this->getNom();
    }
}
