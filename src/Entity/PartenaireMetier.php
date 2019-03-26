<?php

namespace App\Entity;

use App\Repository\MetierRepository;


class PartenaireMetier
{

    private $id;

    private $partenaire;

    private $metier;
    private $metierRepository;

    public function __construct(MetierRepository $metierRepository)
    {
        $this->metierRepository = $metierRepository;
    }
    public function getMetier(): ?Metier
    {
        return $this->metier;
    }

    public function setMetier(Metier $metier): self
    {
        $this->metier = $metier;

        return $this;
    }
    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }
    public function getNomMetier(): ?string
    {
        if ($this->metier == null ) return null;
        return $this->metier->getNom();
    }
    public function setNomMetier(string $nom): ?Metier
    {
        $metier = $this->metierRepository->findOneByNom($nom);
        if ($metier == null ) return null;
        $this->metier = $metier;
        return $this->metier;
    }
    public function setPartenaire(Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;
        
        return $this;
    }
    public function __toString() :string {
        return $this->partenaire."".$this->metier ;
    }
}
