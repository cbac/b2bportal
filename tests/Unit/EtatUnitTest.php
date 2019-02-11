<?php
namespace App\UnitTests;

use App\Entity\Etat;
use PHPUnit\Framework\TestCase;



class TodoUnitTest extends TestCase
{
    public function testCtr()
    {
        $etat = new Etat();
         
        // assert that your calculator added the numbers correctly!
        $this->assertEquals("new", $etat->getCurrent());
        $etat->next();
        $this->assertEquals("devis demandé", $etat->getCurrent());
        $etat->next();
        $this->assertEquals("devis accepté", $etat->getCurrent()); 
        $etat->next();
        $this->assertEquals("en cours de réalisation", $etat->getCurrent());
        $etat->next();
        $this->assertEquals("terminé", $etat->getCurrent());
        $etat->next();
        $this->assertEquals("facturé", $etat->getCurrent());
        $etat->next();
        $this->assertEquals("payé", $etat->getCurrent());
        $etat->next();
        $this->assertEquals("fermé", $etat->getCurrent());
        
    }
}