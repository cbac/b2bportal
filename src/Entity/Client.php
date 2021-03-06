<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"client" = "Client", "partenaire" = "Partenaire"})
 * @ApiResource
 */
class Client
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="client", orphanRemoval=true)
     */
    private $evenements;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="client", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Localisation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $localisation;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setClient($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getClient() === $this) {
                $evenement->setClient(null);
            }
        }

        return $this;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }
    public function getAddress(): ?string
    {
        if($this->localisation == null){
            return null;
        }
        return $this->localisation->getAddress();
    }
    public function setAddress(string $newAddress) : Localisation
    {
        if($this->localisation == null){
            $this->localisation = new Localisation();
        }
        $res = $this->localisation->setAddress($newAddress);
        $this->localisation->calculateLatLon();
        return $res;
    }
    public function getNewAddress(): ?string
    {
        return null;
    }
    public function setNewAddress(string $newAddress) : Localisation
    {
        return $this->setAddress($newAddress);
    }
    public function setLocalisation(Localisation $localisation): self
    { $this->localisation = $localisation;
    return $this;
    }
    
    public function __toString() :string {
        return $this->nom." ".$this->prenom;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
