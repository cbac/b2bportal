<?php
namespace App\Entity;

use App\Repository\MetierRepository;

/**
 * La classe PartenaireMetier représente l'association NxN entre les partenaires et les metiers.
 * Elle a été créee de manière automatique lors de la création de la classe Partenaire.
 * Cette classe a fait l'objet de l'ajout des méthodes getNomMetier et setNomMetier.
 * Afin de permettre de faire un formulaire type menu déroulant pour ajouter un métier à un partenaire.
 * À cette fin il est nécessaire d'injecter le repository de la classe Metier dans le constructeur
 * pour rechercher un Metier à partir de son nom dans la méthode setNomMetier.
 *
 * @author chris
 *        
 */
class PartenaireMetier
{

    private $id;

    private $partenaire;

    private $metier;

    /**
     * Le repository de la classe Metier permet de rechercher un Metier à partir de son nom
     * lorsqu'on utilise la méthode setNomMetier, afin d'associer le metier.
     * @var MetierRepository
     */
    private $metierRepository;

    /**
     * L'injection du repository de la classe Metier permet de rechercher un Metier à partir de son nom
     * lorsqu'on utilise la méthode setNomMetier, afin d'associer le metier.
     *
     * @param MetierRepository $metierRepository
     */
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

    /**
     * Cette méthode est un relai vers la classe Metier pour permettre le remplissage de manière
     * automatique du formulaire par createForm.
     *
     * @return string|NULL
     */
    public function getNomMetier(): ?string
    {
        if ($this->metier == null)
            return null;
        return $this->metier->getNom();
    }

    /**
     * Cette méthode est un relai vers la classe Metier pour permettre le remplissage de manière
     * automatique du formulaire App\\Form\AddPartenaireMetier par createForm.
     * Elle permet d'associer le Metier correspondant au nom passé en paramêtre lors du POST.
     *
     * @return Metier|NULL
     */
    public function setNomMetier(string $nom): ?Metier
    {
        $metier = $this->metierRepository->findOneByNom($nom);
        if ($metier == null)
            return null;
        $this->metier = $metier;
        return $this->metier;
    }

    public function setPartenaire(Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    public function __toString(): string
    {
        return $this->partenaire . "" . $this->metier;
    }
}
