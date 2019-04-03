<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Etat;
use App\Entity\Localisation;
use App\Entity\Metier;use App\Entity\TypePrestation;
use App\Entity\TypeEvenement;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadLocalisation($manager);
        $this->loadMetier($manager);
        $this->loadTypePrestation($manager);
        $this->loadEtats($manager);
        $manager->flush();
        
        $this->loadTypeEvenement($manager);
        $manager->flush();
    }

    private function loadLocalisation(ObjectManager $manager)
    {
        foreach ($this->getLocalisationData() as [$address]) {
            $localisation = new Localisation();
            $localisation->setAddress($address);
            $manager->persist($localisation);
        }
    }

    private function getLocalisationData()
    {
        yield ['10 rue Jean Mermoz, 91080, Evry-Courcouronnes, France'];
        yield ["rond point de l'étoile, 33510, ANDERNOS LES BAINS, France"];
        yield ['11 rue charles fourier, 91000, Evry-Courcouronnes, France'];
        yield ['11 avenue du parc aux biches, 91000, Evry-Courcouronnes, France'];
        
    }
    private function loadEtats(ObjectManager $manager)
    {
        for($i=0;$i<Etat::getMax();$i++) {
            $etat = new Etat();
            $etat->setCurrent($i);
            $manager->persist($etat);
        }
    }
    private function loadMetier(ObjectManager $manager)
    {
        foreach ($this->getMetierData() as [$nom_metier]) {
            $metier = new Metier();
            $metier->setNom($nom_metier);
            $manager->persist($metier);
        }
    }
    
    private function getMetierData()
    {
        yield ['Traiteur'];
        yield ['Location salle'];
        yield ['Service en salle'];
        yield ['Sécurité événementielle'];
        yield ['DJ'];
        yield ['Orchestre'];
    }
    private function loadTypePrestation(ObjectManager $manager)
    {
        foreach ($this->getTypePrestationData() as [$nom_type_prestation,$description]) {
            $typePrestation = new TypePrestation();
            $typePrestation->setNomType($nom_type_prestation);
            $typePrestation->setDescription($description);
            $manager->persist($typePrestation);
        }
    }
    
    private function getTypePrestationData()
    {
        yield ['Buffet froid', 'Buffet composé de plats froids'];
        yield ['Buffet chaud', 'Buffet avec plats chauds'];
        yield ['Cocktail kir', 'Apéritif kir et softs + 8 petits fours par personne'];
        yield ['Cocktail kir royal', 'Apéritif kir royal et softs + 8 petits fours par personne'];
        yield ['Sécurité événementielle', 'Service de sécurité, filtrage entrée, gardiennage parking'];
        yield ['DJ','Animation par disque jockey, choix de musiques large'];
        yield ['Orchestre danses de salon', 'Animation par orchestre spécialisé en danses de salon'];
        yield ['Orchestre danses latines', 'Animation par orchestre spécialisé en danses latines'];
        yield ['Location salle', 'Location de salle pour événement'];
        yield ['Mariage', "Organisation de l'ensemble des prestations pour un mariage"];
        yield ['Anniversaire', "Organisation de l'ensemble des prestations pour un anniversaire"];
        
    } 
    private function loadTypeEvenement(ObjectManager $manager)
    {

        foreach ($this->getTypeEvenementData() as [$nom, $nomTypePrestation]) {
            $typeEvenement = new TypeEvenement();
            $typeEvenement->setNom($nom);
            $typePrestation = $manager->getRepository('App\Entity\TypePrestation')
            ->findByNomType($nomTypePrestation);
            if(is_null($typePrestation)) continue;
            $typeEvenement->setTypePrestation($typePrestation[0]);
            $manager->persist($typeEvenement);
        }
    }
    
    private function getTypeEvenementData()
    {
        yield ['Buffet froid','Buffet froid'];
        yield ['Buffet chaud','Buffet chaud'];
        yield ['Cocktail kir','Cocktail kir'];
        yield ['Cocktail kir royal', 'Cocktail kir royal'];
        yield ['Mariage', 'Mariage'];
        yield ['Anniversaire', 'Anniversaire'];
    }
    
}