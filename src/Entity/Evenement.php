<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Prestation;
use App\Repository\EtatRepository;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 *
 */
class Evenement
{

    /**
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="evenement", orphanRemoval=true)
     */
    private $prestations;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Localisation", inversedBy="evenements")
     */
    private $localisation;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeEvenement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeEvenement;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypePrestation")
     */
    private $typesPrestation;

    public function __construct()
    {
        $this->prestations = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     *
     * @return Collection|Prestation[]
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestation $prestation): self
    {
        if (! $this->prestations->contains($prestation)) {
            $this->prestations[] = $prestation;
            $prestation->setEvenement($this);
        }

        return $this;
    }

    public function removePrestation(Prestation $prestation): self
    {
        if ($this->prestations->contains($prestation)) {
            $this->prestations->removeElement($prestation);
            // set the owning side to null (unless already changed)
            if ($prestation->getEvenement() === $this) {
                $prestation->setEvenement(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }

    public function setLocalisation(?Localisation $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Relay function to modify Evenement status
     *
     * @return int
     */
    public function next(EtatRepository $etatRepository): int
    {
        if ($this->etat == null) {
            $next = $etatRepository->findOneBy([
                'current' => 0
            ]);
            $this->etat = $next;
        }
        $minPrestations = Etat::getMax();
        if (count($this->prestations) > 0) {
            foreach ($this->prestations as $prestation) {
                if ($prestation->getEtat()->getCurrent() < $minPrestations) {
                    $minPrestations = $prestation->getEtat()->getCurrent();
                }
            }
        } else {
            // no prestation is associated to this event
            return 0;
        }

        $myCurrent = $this->etat->getCurrent();
        $next = new Etat();
        if ($minPrestations > $myCurrent) {
            $next = $etatRepository->findOneBy([
                'current' => $minPrestations
            ]);
            $this->etat = $next;
        }
        return $myCurrent;
    }

    public function getCurrent(): string
    {
        return $this->etat->getCurrent();
    }

    public function getTypeEvenement(): ?TypeEvenement
    {
        return $this->typeEvenement;
    }

    public function setTypeEvenement(?TypeEvenement $typeEvenement): self
    {
        $this->typeEvenement = $typeEvenement;
        if($typeEvenement!=null && $this->typesPrestation->isEmpty()) {
            // Copy list of TypePrestation from typeEvenement
            $this->addTypePrestation($typeEvenement->getTypePrestation());
        }
        return $this;
    }
    /**
     *
     * @return Collection|TypePrestation[]
     */
    public function getTypesPrestation(): Collection
    {
        return $this->typesPrestation;
    }
    
    public function addTypePrestation(TypePrestation $typePrestation): self
    {
        if (! $this->typesPrestation->contains($typePrestation)) {
            $this->typesPrestation[] = $typePrestation;
        }
        return $this;
    }
    
    public function removeTypePrestation(TypePrestation $typePrestation): self
    {
        if ($this->typesPrestation->contains($typePrestation)) {
            $this->typesPrestation->removeElement($typePrestation);
        }
        return $this;
    }
    
}
