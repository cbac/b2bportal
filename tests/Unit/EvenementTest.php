<?php
namespace tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Entity\Evenement;
use App\Entity\TypeEvenement;


class EvenementTest  extends TestCase
{
    public function testCtr() {
        $typeEvt = new TypeEvenement();
        $typeEvt->setNom('test');
        $evt = new Evenement();
        $evt->setNom('Evenement');
        // check setNom getNom ok 
        $this->assertEquals("Evenement",$evt->getNom());
        // check setType getType ok
        $evt->setType($typeEvt);
        $this->assertEquals($typeEvt, $evt->getType());
    }
}

