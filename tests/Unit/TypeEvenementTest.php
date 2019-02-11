<?php
namespace tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Entity\TypeEvenement;

class TypeEvenementTest  extends TestCase
{
    public function testCtr() {
        $typeEvt = new TypeEvenement();
        $typeEvt->setNom('test');
        $this->assertEquals("test",$typeEvt->getNom());
    }
}

