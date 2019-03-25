<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Prestation;

/**
 *
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CatalogueRepository")
 */
class Catalogue
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
     * @ORM\Column(type="float", nullable=true)
     */
    private $tarifPublic;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="catalogues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partenaire;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TypePrestation",inversedBy="catalogues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typePrestation;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Prestation", mappedBy="catalogue")
     */
    private $prestations;

    public function __construct()
    {
        $this->prestations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarifPublic(): ?float
    {
        return $this->tarifPublic;
    }

    public function setTarifPublic(?float $tarifPublic): self
    {
        $this->tarifPublic = $tarifPublic;

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
/**
 * relay method for twig access to TypePrestation field
 * @return string|NULL
 */
    public function getNomType()
    {
        if (isset($this->typePrestation)) {
            return $this->typePrestation->getNomType();
        }
        return null;
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
            $prestation->setCatalogue($this);
        }

        return $this;
    }

    public function removePrestation(Prestation $prestation): self
    {
        if ($this->prestations->contains($prestation)) {
            $this->prestations->removeElement($prestation);
            // set the owning side to null (unless already changed)
            if ($prestation->getCatalogue() === $this) {
                $prestation->setCatalogue(null);
            }
        }

        return $this;
    }
}
