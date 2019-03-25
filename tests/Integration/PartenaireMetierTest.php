<?php
namespace tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Partenaire;
use App\Entity\TypePrestation;
use App\Entity\Metier;
use App\Entity\Client;
use App\Entity\Prestation;
use App\Entity\Evenement;
use App\Entity\Catalogue;
use App\Entity\TypeEvenement;

class PartenaireMetierTest extends TestCase
{

    public function testMetiers()
    {
        $partenaire = new Partenaire();

        $metier = new Metier();
        $metier->setNom('test_metier');
        $partenaire->addMetier($metier);
        // check size has grown
        $this->assertEquals(1, count($partenaire->getMetiers()));

        // try add another an entry 
        $metier1 = new Metier();
        $metier1->setNom('test_metier_1');
        $partenaire->addMetier($metier1);
        // check size 
        $this->assertEquals(2, count($partenaire->getMetiers()));
        // can we remove entries
        $partenaire->removeMetier($metier1);
        $partenaire->removeMetier($metier);
        
        // check collection is empty
        $this->assertTrue($partenaire->getMetiers()
            ->isEmpty());
    }

    public function testCatalogues() {
        $partenaire = new Partenaire();
        
        $typePrestation = new TypePrestation();
        $typePrestation->setNomType('test_type_prestation');
        $catEntry = new Catalogue();
        $catEntry->setTypePrestation($typePrestation);
        $catEntry->setTarifPublic(100);
        $partenaire->addCatalogue($catEntry);
        // check size has grown
        $this->assertEquals(1,count($partenaire->getCatalogues()));
        // can we add it twice ?
        $partenaire->addCatalogue($catEntry);
        // check size has not grown
        $this->assertEquals(1,count($partenaire->getCatalogues()));
        // try to remove an entry not in collection
        $catEntry1 = new Catalogue();
        $typePrestation1 = new TypePrestation();
        $typePrestation1->setNomType('test_type_prestation1');
        $catEntry1->setTypePrestation($typePrestation1);
        $catEntry->setTarifPublic(120);
        $partenaire->removeCatalogue($catEntry1);
        // check size has not shrunk
        $this->assertEquals(1,count($partenaire->getCatalogues()));
        // can we remove first entry
        $partenaire->removeCatalogue($catEntry);
        // check size has shrunk
        $this->assertTrue($partenaire->getCatalogues()->isEmpty());
    }

    public function testPrestations() {
        $partenaire = new Partenaire();
        $metier = new Metier();
        $metier->setNom('metier_test');
        
        $typePrestation = new TypePrestation();
        $typePrestation->setNomType('type_prestation_test');
        $catEntry = new Catalogue();
        $catEntry->setTypePrestation($typePrestation);
        $catEntry->setTarifPublic(100);
        $prestation = new Prestation();
        $prestation->setCatalogue($catEntry);
        $partenaire->addPrestation($prestation);
        // check size has grown
        $this->assertEquals(1,count($partenaire->getPrestations()));
        // can we add it twice ?
        $partenaire->addPrestation($prestation);
        // check size has not grown
        $this->assertEquals(1,count($partenaire->getPrestations()));
        // try to remove an entry not in collection
        $prestation1 = new Prestation();
        $prestation1->setCatalogue($catEntry);
        
        $partenaire->removePrestation($prestation1);
        // check size has not shrunk
        $this->assertEquals(1,count($partenaire->getPrestations()));
        // can we remove first entry
        $partenaire->removePrestation($prestation);
        // check size has shrunk
        $this->assertTrue($partenaire->getPrestations()->isEmpty());
    }
    public function testTypeEvenements() {
        $partenaire = new Partenaire();
        $metier = new Metier();
        $metier->setNom('metier_test');
        
        $typeEvenement = new TypeEvenement();
        $typeEvenement->setNom('type_evenement_test');
        $partenaire->addTypeEvenement($typeEvenement);
        // check size has grown
        $this->assertEquals(1,count($partenaire->getTypeEvenements()));
        // can we add it twice ?
        $partenaire->addTypeEvenement($typeEvenement);
        // check size has not grown
        $this->assertEquals(1,count($partenaire->getTypeEvenements()));
        // try to remove an entry not in collection
        $typeEvenement1 = new TypeEvenement();
        $typeEvenement1->setNom('type_evenement_test_1');
        
        $partenaire->removeTypeEvenement($typeEvenement1);
        // check size has not shrunk
        $this->assertEquals(1,count($partenaire->getTypeEvenements()));
        // can we remove first entry
        $partenaire->removeTypeEvenement($typeEvenement);
        // check size has shrunk
        $this->assertTrue($partenaire->getTypeEvenements()->isEmpty());

    }
}

