<?php
namespace App\UnitTests;

use PHPUnit\Framework\TestCase;
use App\Entity\Localisation;

class LocationTest extends TestCase
{
    public function testLocalisation()
    {
        $location = new Localisation();
        $location->setAddress("Greenwitch, England");
        $location->setLatitude(0.0);
        $location->setLongitude(0.0);
        $this->assertEquals("Greenwitch, England", $location->getAddress());
        $this->assertEquals(0.0,$location->getLatitude());
        $this->assertEquals(0.0,$location->getLongitude());
    }
}

