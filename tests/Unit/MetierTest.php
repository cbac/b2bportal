<?php
namespace tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Entity\Metier;
use App\Entity\TypePrestation;


class MetierTest  extends TestCase
{
    public function testCtr() {
        $metier = new Metier();
        $metier->setNom('test');
        $this->assertEquals('test', $metier->getNom());
        // check __toString == getNom
        $this->assertEquals('test', $metier->__toString());
        // check ArrayCollection is set
        $this->assertNotNull($metier->gettypesPrestation());
        // check Collection is empty
        $this->assertTrue($metier->gettypesPrestation()->isEmpty());
    }
    public function testAddTypePrestation() {
        $metier = new Metier();
        $presta = new TypePrestation();
        $presta->setNomType('type1');
        // check add 1 type
        $metier->addtypePrestation($presta);
        $types = $metier->gettypesPrestation();
        // check nothing happens if we add the same type
        $this->assertEquals(1, count($types));
        $metier->addtypePrestation($presta);
        $types = $metier->gettypesPrestation();
        $this->assertEquals(1, count($types));
        // check that size grows when we add a second type
        $presta = new TypePrestation();
        $presta->setNomType('type2');
        $metier->addtypePrestation($presta);
        $this->assertEquals(2, count($types));
    }
    public function testDelTypePrestation() {
        $metier = new Metier();
        $presta1 = new TypePrestation();
        $presta1->setNomType('type1');
        $metier->addtypePrestation($presta1);
        $presta2 = new TypePrestation();
        $presta2->setNomType('type2');
        // check that remove is harmless if the TypePrestation
        // is not in the collection
        $metier->removetypePrestation($presta2);
        $types = $metier->gettypesPrestation();
        $this->assertEquals(1, count($types));
        // chek that remove is ok 
        $metier->removetypePrestation($presta1);
        $types = $metier->gettypesPrestation();
        $this->assertEquals(0, count($types));
    }
}

