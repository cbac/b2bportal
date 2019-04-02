<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Etat;
use Doctrine\Common\Collections\Collection;

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

    public function getDateDebut(): ? \DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTime $dateDebut): self
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

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTime $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }
/**
 * Only for Doctrine
 * Normal usage is to use next to make Etat progress
 * @param Etat $etat
 * @return self
 */
    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
    /**
     * Relay function to modify Prestation status
     * @return string
     */
    public function next() : int
    {
        $res = $this->etat->next(); 
        // try to change the evenement status
        $this->evenement->next();
        return $res;
    }
    public function getCurrent():int
    {
        return $this->etat->getCurrent();   
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

}
