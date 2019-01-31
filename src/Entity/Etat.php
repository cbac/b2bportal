<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Etat
 * @ORM\Entity()
 */
class Etat {
    const created = "new";
    const invoiced = "devis demandés";
    const accepted = "devis accepté";
    const started = "en cours de réalisation";
    const finished ="terminé";
    const paid = "payé";
    const closed = "fermé";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $current = created;
    
    public function __construct(){
        $this->current = created;
    }
    public function getCurrent():string {
        return $this->current;
    }
    public function next() : string {
        $old = $this->current;
        if ($old == created) {
            $this->current = invoiced;
        } elseif ($old == invoiced) {
            $this->current = accepted;
        } elseif($old = accepted) {
            $this->current = started;   
        } elseif ($old==started){
            $this->current = finished;
        } elseif ($this->current == finished){
            $this->current=paid;
        } elseif ($this->current==paid){
            $this->current = closed;
        }
        return $old;
    }
    public function setCurrent($newVal) : string{
        $old = $this->current;
        $this->current = $newVal;
        return $old;
    }
}