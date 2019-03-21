<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Etat;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\PrestationRepository")
 */
class Prestation
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
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Prestation", inversedBy="sousPrestations")
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="parent")
     */
    private $sousPrestations;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Etat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement", inversedBy="prestations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evenement;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="prestations")
     */
    private $partenaire;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogue", inversedBy="prestations")
     */
    private $catalogue;

    public function __construct()
    {
        $this->sousPrestations = new ArrayCollection();
        $this->parent = null;
        $this->etat = new Etat();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getTypePrestation(): ?TypePrestation
    {
        if (isset($this->catalogue)) {
            return $this->catalogue->getTypePrestation();
        }
        return null;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     *
     * @return Collection|self[]
     */
    public function getSousPrestations(): Collection
    {
        return $this->sousPrestations;
    }

    public function addSousPrestation(self $sousPrestation): self
    {
        if (! $this->sousPrestations->contains($sousPrestation)) {
            $this->sousPrestations[] = $sousPrestation;
            $sousPrestation->setParent($this);
        }

        return $this;
    }

    public function removeSousPrestation(self $sousPrestation): self
    {
        if ($this->sousPrestations->contains($sousPrestation)) {
            $this->sousPrestations->removeElement($sousPrestation);
            // set the owning side to null (unless already changed)
            if ($sousPrestation->getParent() === $this) {
                $sousPrestation->setParent(null);
            }
        }

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

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;
        $this->dateDebut = $evenement->getDate();
        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    public function __toString(): ?string
    {
        if(isset($this->catalogue) && isset($this->evenement)){
            $myTypePrestation = $this->catalogue->getTypePrestation();
            if(isset($myTypePrestation)){
                return $myTypePrestation->__toString().' pour '.$this->evenement->__toString();
            }
        }
        return null;
    }

    public function getCatalogue(): ?Catalogue
    {
        return $this->catalogue;
    }

    public function setCatalogue(?Catalogue $catalogue): self
    {
        $this->catalogue = $catalogue;
        if(isset($catalogue)){
            $this->partenaire = $catalogue->getPartenaire();
        }

        return $this;
    }
}
