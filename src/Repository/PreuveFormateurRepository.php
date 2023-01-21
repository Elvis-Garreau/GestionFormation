<?php

namespace App\Repository;

use App\Entity\PreuveFormateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PreuveFormateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreuveFormateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreuveFormateur[]    findAll()
 * @method PreuveFormateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreuveFormateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PreuveFormateur::class);
    }

    // /**
    //  * @return PreuveFormateur[] Returns an array of PreuveFormateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PreuveFormateur
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
