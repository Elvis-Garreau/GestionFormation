<?php

namespace App\Repository;

use App\Entity\BiblDocu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BiblDocu|null find($id, $lockMode = null, $lockVersion = null)
 * @method BiblDocu|null findOneBy(array $criteria, array $orderBy = null)
 * @method BiblDocu[]    findAll()
 * @method BiblDocu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiblDocuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BiblDocu::class);
    }

    // /**
    //  * @return BiblDocu[] Returns an array of BiblDocu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BiblDocu
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
