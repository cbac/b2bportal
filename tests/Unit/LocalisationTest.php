<?php
namespace App\UnitTests;

use PHPUnit\Framework\TestCase;
use App\Entity\Localisation;

class LocalisationTest extends TestCase
{
    public function testSettersGetters()
    {
        $location = new Localisation();
        $location->setAddress("Paris, France");
        $location->setLatitude(48.85341);
        $location->setLongitude(2.3488);
        $this->assertEquals("Paris, France", $location->getAddress());
        $this->assertEquals(48.85341,$location->getLatitude());
        $this->assertEquals(2.3488,$location->getLongitude());
    }
    public function testLatLongCalculator()
    {
        $location = new Localisation();
        $location->setAddress("Place de l'Hôtel de Ville, 75004, Paris, France");
        $this->assertEquals(48.8566689,$location->getLatitude());
        $this->assertEquals(2.3510273,$location->getLongitude());
        
    }
}

