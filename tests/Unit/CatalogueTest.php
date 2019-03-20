<?php
namespace tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Entity\Partenaire;
use App\Entity\TypePrestation;
use App\Entity\Catalogue;
use App\Entity\Prestation;



class CatalogueTest  extends TestCase
{
    public function testCtr() {
        $partenaire = new Partenaire();
        $partenaire->setNom('partenaire_test');
        $catalogue = new Catalogue();        
        $catalogue->setPartenaire($partenaire);
        $this->assertEquals($partenaire, $catalogue->getPartenaire());
        
        $typePrestation = new TypePrestation();
        $typePrestation->setNomType('type_prestation_test');
        $catalogue->setTypePrestation($typePrestation);
        $this->assertEquals($typePrestation, $catalogue->getTypePrestation());
        $catalogue->setTarifPublic(100);
        $this->assertEquals(100,$catalogue->getTarifPublic());
        
        // check ArrayCollection is set
        $this->assertNotNull($catalogue->getPrestations());
        // check Collection is empty
        $this->assertTrue($catalogue->getPrestations()->isEmpty());
    }
    public function testCollection() {
        $partenaire = new Partenaire();
        $partenaire->setNom('partenaire_test');
        $catalogue = new Catalogue();
        $catalogue->setPartenaire($partenaire);
        $typePrestation = new TypePrestation();
        $typePrestation->setNomType('type_prestation_test');
        $catalogue->setTypePrestation($typePrestation);
        $catalogue->setTarifPublic(100);
        
        $presta = new Prestation();
        $presta->setCatalogue($catalogue);
        $presta->setDateDebut(date_create());
        $presta->setDateFin(date_create('tomorrow'));
        // check add 1 type
        $catalogue->addPrestation($presta);
        $this->assertEquals(1, count($catalogue->getPrestations()));
        // check nothing happens if we add the same Prestation
        $catalogue->addPrestation($presta);
        $this->assertEquals(1, count($catalogue->getPrestations()));
        // check that size grows when we add a second Prestation
        $presta1 = new Prestation();
        $presta1->setCatalogue($catalogue);
        $presta1->setDateDebut(date_create());
        $presta1->setDateFin(date_create('tomorrow'));
        $catalogue->addPrestation($presta1);
        $this->assertEquals(2, count($catalogue->getPrestations()));
    }
}

