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
        $this->assertEquals(Etat::created, $etat->getCurrent());
        $etat->next();
        $this->assertEquals(Etat::estimated, $etat->getCurrent());
        $etat->next();
        $this->assertEquals(Etat::accepted, $etat->getCurrent()); 
        $etat->next();
        $this->assertEquals(Etat::started, $etat->getCurrent());
        $etat->next();
        $this->assertEquals(Etat::finished, $etat->getCurrent());
        $etat->next();
        $this->assertEquals(Etat::invoiced, $etat->getCurrent());
        $etat->next();
        $this->assertEquals(Etat::paid, $etat->getCurrent());
        $etat->next();
        $this->assertEquals(Etat::closed, $etat->getCurrent());
        
    }
}