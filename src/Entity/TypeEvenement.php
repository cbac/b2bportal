<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Tests\Fixtures\SingleIntIdNoToStringEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeEvenementRepository")
 */
class TypeEvenement
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
     * @ORM\ManyToOne(targetEntity="App\Entity\TypePrestation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typePrestation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partenaire", mappedBy="typeEvenement")
     */
    private $partenaire;

    public function __construct()
    {
        $this->partenaire = new ArrayCollection();
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
    public function __toString(): ? String
    {
        return $this->nom;
    }

    public function getTypePrestation(): ?TypePrestation
    {
        return $this->typePrestation;
    }

    public function setTypePrestation(?TypePrestation $typePrestation): self
    {
        $this->typePrestation = $typePrestation;

        return $this;
    }

    /**
     * @return Collection|Partenaire[]
     */
    public function getPartenaire(): Collection
    {
        return $this->partenaire;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaire->contains($partenaire)) {
            $this->partenaire[] = $partenaire;
            $partenaire->setTypeEvenement($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaire->contains($partenaire)) {
            $this->partenaire->removeElement($partenaire);
            // set the owning side to null (unless already changed)
            if ($partenaire->getTypeEvenement() === $this) {
                $partenaire->setTypeEvenement(null);
            }
        }

        return $this;
    }
}
