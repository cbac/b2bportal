<?php
namespace tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Entity\Metier;
use App\Entity\TypePrestation;


class CatalogueTest  extends TestCase
{
    public function testCtr() {
        $metier = new Metier();
        $metier->setNom('test');
        $this->assertEquals('test', $metier->getNom());
        // check __toString == getNom
        $this->assertEquals('test', $metier->__toString());
        // check ArrayCollection is set
        $this->assertNotNull($metier->gettypesPrestation());
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
}

