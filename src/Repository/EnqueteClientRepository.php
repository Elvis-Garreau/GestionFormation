<?php

namespace App\Repository;

use App\Entity\EnqueteClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnqueteClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnqueteClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnqueteClient[]    findAll()
 * @method EnqueteClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnqueteClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnqueteClient::class);
    }

    public function findByPlanif($planif)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.planif = :planif')
            ->setParameter('planif', $planif)
        ;
        $query = $qb->getQuery();

        return $query;
    }

    // /**
    //  * @return EnqueteClient[] Returns an array of EnqueteClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EnqueteClient
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
