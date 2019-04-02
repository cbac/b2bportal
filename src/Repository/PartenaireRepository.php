<?php

namespace App\Repository;

use App\Entity\Partenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Partenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partenaire[]    findAll()
 * @method Partenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartenaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Partenaire::class);
    }

 /*   public function findAll()
    {
        return $this->findBy(array('discr'=>'Partenaire'), array('nom' => 'ASC', 'prenom' => 'ASC'));
    }
    public function findById() {
        return $this->findBy(array('discr'=>'Partenaire'), array('id' => 'ASC'));
    }
    */
}
