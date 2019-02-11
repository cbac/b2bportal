<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Etat
 * @ORM\Entity()
 */
class Etat {
    const created = "new";
    const estimated= "devis demandé";
    const accepted = "devis accepté";
    const started = "en cours de réalisation";
    const finished ="terminé";
    const invoiced ="facturé";
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
    private $current = self::created;
    
    public function __construct(){
        $this->current = self::created;
    }
    public function getCurrent():string {
        return $this->current;
    }
    public function next() : string {
        $old = $this->current;
        switch ($old) { 
            case self::created : 
                $this->current = self::estimated;
                break;
            case self::estimated :
                $this->current = self::accepted;
               break;
            case self::accepted :
                $this->current = self::started; 
                break;
            case self::started :
                $this->current = self::finished;
                break;
            case  self::finished :
                $this->current = self::invoiced;
                break;
            case  self::invoiced :
                $this->current = self::paid;
                break;
            case self::paid:
            $this->current = self::closed;
            break;
        }
        return $old;
    }
    public function setCurrent($newVal) : string{
        $old = $this->current;
        $this->current = $newVal;
        return $old;
    }
    public function __toString(){
        return $this->current;
    }
}