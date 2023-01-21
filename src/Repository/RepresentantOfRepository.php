<?php

namespace App\Repository;

use App\Entity\RepresentantOf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepresentantOf|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepresentantOf|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepresentantOf[]    findAll()
 * @method RepresentantOf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepresentantOfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepresentantOf::class);
    }

    public function findByOrganisme($organisme)
    {
        $qb = $this->createQueryBuilder('representant_of')
            ->where('representant_of.organisme = :organisme')
            ->setParameter('organisme', $organisme)
        ;
        $query = $qb->getQuery();

        return $query->execute();
    }

    // /**
    //  * @return RepresentantOf[] Returns an array of RepresentantOf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RepresentantOf
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
