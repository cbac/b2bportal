<?php
namespace tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Entity\Partenaire;
use App\Entity\TypePrestation;
use App\Entity\Metier;
use App\Entity\Etat;
use App\Entity\Prestation;
use App\Entity\Evenement;
use App\Entity\Catalogue;
use App\Entity\TypeEvenement;


class PrestationTest  extends TestCase
{
    public function testCtr() {
        $prestation = new Prestation();

        // check scollection are initialized and empty
        $this->assertNotNull($prestation->getSousPrestations());
        $this->assertTrue($prestation->getSousPrestations()->isEmpty());
        // parent should be null
        $this->assertNull($prestation->getParent());
        // Etat should be created
        $etat = $prestation->getEtat();
        $this->assertEquals(Etat::created, $etat->getCurrent());
        // Partenaire evenement and dates are unset
        $this->assertNull($prestation->getPartenaire());
        $this->assertNull($prestation->getDateDebut());
        $this->assertNull($prestation->getDateFin());
        $this->assertNull($prestation->getEvenement());
    }
    public function testAssociations() {
        $partenaire = new Partenaire();
        
        $typePrestation = new TypePrestation();
        $typePrestation->setNomType('test_type_prestation');
        $catEntry = new Catalogue();
        $catEntry->setTypePrestation($typePrestation);
        $catEntry->setTarifPublic(100);
        $partenaire->addCatalogue($catEntry);
        
        $prestation = new Prestation();
        $prestation->setCatalogue($catEntry);
        
        // check relation to TypePrestation is OK
        $this->assertEquals($typePrestation,$prestation->getTypePrestation());
        
        // check Partenaire has been set
        $this->assertEquals($partenaire,$prestation->getPartenaire());
        // set Evenement should set the date
        $evenement = new Evenement();
        $start_date = date_create();
        $evenement->setDate($start_date);
        $prestation->setEvenement($evenement);
        $this->assertEquals($start_date, $prestation->getDateDebut());
    }
}

