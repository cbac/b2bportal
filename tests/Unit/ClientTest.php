<?php
namespace tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Entity\Metier;
use App\Entity\TypePrestation;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Localisation;
use App\Entity\Evenement;


class ClientTest  extends TestCase
{
    public function testCtr() {
        $client = new Client();
        $client->setNom('test');
        $this->assertEquals('test', $client->getNom());
        $client->setPrenom('test');
        $this->assertEquals('test', $client->getPrenom());
        // check __toString == nom." ". prenom
        $this->assertEquals('test test', $client->__toString());
        // check set/get on relations
        $localisation = new Localisation();
        $client->setLocalisation($localisation);
        $this->assertEquals($localisation, $client->getLocalisation());
        $user = new User();
        $client->setUser($user);
        $this->assertEquals($user, $client->getUser());
        // check collection is initialized
        $this->assertNotNull($client->getEvenements());
        // check collection is empty
        $this->assertTrue($client->getEvenements()->isEmpty());
    }
    public function testAddEvenements() {
        $client = new Client();
        $evt = new Evenement();
        $evt->setNom('type1');
        // check add 1 evt
        $client->addEvenement($evt);
        $this->assertEquals(1, count($client->getEvenements()));
        // check nothing happens if we add the same evenement
        $client->addEvenement($evt);
        $this->assertEquals(1, count($client->getEvenements()));
        // add second evenement
        $evt1 = new Evenement();
        $evt1->setNom('type2');
        $client->addEvenement($evt1);
        // check size is now 2
        $this->assertEquals(2, count($client->getEvenements()));
    }
    public function testDelTypePrestation() {
        $client = new Client();
        $evt = new Evenement();
        $evt->setNom('type1');
        $evt1 = new Evenement();
        $evt1->setNom('type2');
        $client->addEvenement($evt);
        // check nothing happens if we remove another evenement
        $client->removeEvenement($evt1);
        $this->assertEquals(1, count($client->getEvenements()));
        // remove the first evenement
        $client->removeEvenement($evt);
        // check that size is now 0
        $this->assertEquals(0, count($client->getEvenements()));

    }
}

