<?php

namespace App\Entity;



class MetierTypePrestation
{

    private $metier;

    private $typePrestation;

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
    
    public function setTypePrestation(TypePrestation $typePrestation): self
    {
        $this->typePrestation = $typePrestation;
        
        return $this;
    }
    public function __toString() :string {
        return $this->metier."".$this->typePrestation ;
    }
}
