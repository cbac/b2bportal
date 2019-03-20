<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetierRepository")
 */
class Metier
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
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypePrestation")
     */
    private $typesPrestation;

    public function __construct()
    {
        $this->typesPrestation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|TypePrestation[]
     */
    public function gettypesPrestation(): ?Collection
    {
        return $this->typesPrestation;
    }

    public function addtypePrestation(TypePrestation $typePrestation): self
    {
        if (!$this->typesPrestation->contains($typePrestation)) {
            $this->typesPrestation[] = $typePrestation;
        }

        return $this;
    }

    public function removetypePrestation(TypePrestation $typePrestation): self
    {
        if ($this->typesPrestation->contains($typePrestation)) {
            $this->typesPrestation->removeElement($typePrestation);
        }

        return $this;
    }
    public function __toString() :string {
        return $this->getNom();
    }
}
