<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Etat
 * @ORM\Entity()
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
    private $current = 0;
    
    public function __construct(){
        $this->current = 0;
    }
    public static function getMax(){
        return count(self::myStatus);
    }
    public function getCurrent():int {
        return $this->current;
    }
    public function setCurrent(int $newVal) : int{
        $old = $this->current;
        $this->current = $newVal;
        return $old;
    }
    public function __toString(){
        return self::myStatus[$this->current];
    }
}