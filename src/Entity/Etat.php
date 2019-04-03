<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Etat
 * @ORM\Entity(repositoryClass="App\Repository\EtatRepository")
 */
class Etat {
    const myStatus = array(
        "ouvert",
        "devis demandé",
        "devis accepté",
        "en cours de réalisation",
        "terminé",
        "facturé",
        "payé",
        "clos");
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $current;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;
    
    public function __construct(){
        $this->current = 0;
        $this->value = self::myStatus[0];
    }
    public static function getMax(){
        return count(self::myStatus);
    }
    public function getCurrent():int {
        return $this->current;
    }
    public function setCurrent(int $newVal) : int
    {
        $old = $this->current;
        $this->current = $newVal;
        $this->setValue(self::myStatus[$newVal]);
        return $old;
    }
    public function getValue(): ?string
    {
        return $this->value;
    }
    public function setValue(string $val) : ? string
    {
        return $this->value = $val;
    }
    public function __toString(){
        return $this->value;
    }
}