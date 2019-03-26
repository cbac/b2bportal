<?php

namespace App\Entity;

use App\Repository\TypePrestationRepository;


class MetierTypePrestation
{

    private $id;

    private $metier;

    private $typePrestation;
    private $typePrestationRepository;

    public function __construct(TypePrestationRepository $typePrestationRepository)
    {
        $this->typePrestationRepository = $typePrestationRepository;
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
    public function getTypePrestation(): ?TypePrestation
    {
        return $this->typePrestation;
    }
    public function getNomType(): ?string
    {
        if ($this->typePrestation == null ) return null;
        return $this->typePrestation->getNomType();
    }
    public function setNomType(string $nomType): ?TypePrestation
    {
        $typePrestation = $this->typePrestationRepository->findOneByNomType($nomType);
        if ($typePrestation == null ) return null;
        $this->typePrestation = $typePrestation;
        return $this->typePrestation;
    }
    public function setTypePrestation(TypePrestation $typePrestation): self
    {
        $this->typePrestation = $typePrestation;
        
        return $this;
    }
    public function __toString() :string {
        return $this->metier."".$this->typePrestation ;
    }
}
