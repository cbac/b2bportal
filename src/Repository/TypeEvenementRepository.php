<?php

namespace App\Repository;

use App\Entity\TypeEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeEvenement[]    findAll()
 * @method TypeEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeEvenementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeEvenement::class);
    }
    public function findAll()
    {
        return $this->findBy(array(), array('nom' => 'ASC'));
    }
    // /**
    //  * @return TypeEvenement[] Returns an array of TypeEvenement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeEvenement
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
