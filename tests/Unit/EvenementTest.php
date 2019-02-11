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
        $this->assertEquals("Evenement",$typeEvt->getNom());
        $evt->setType($typeEvt);
        $this->assertEquals($typeEvt, $evt->getType());
    }
}

