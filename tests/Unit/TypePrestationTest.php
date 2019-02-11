<?php
namespace tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Entity\TypePrestation;

class TypePrestationTest  extends TestCase
{
    public function testCtr() {
        $typePresta = new TypePrestation();
        $typePresta->setNomType('test');
        $this->assertEquals('test',$typePresta->getNomType());
    }
}

