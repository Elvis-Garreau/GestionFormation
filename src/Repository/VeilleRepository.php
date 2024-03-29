<?php

namespace App\Repository;

use App\Entity\Veille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Veille|null find($id, $lockMode = null, $lockVersion = null)
 * @method Veille|null findOneBy(array $criteria, array $orderBy = null)
 * @method Veille[]    findAll()
 * @method Veille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VeilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Veille::class);
    }

    public function findByOrganisme($organisme)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.organisme = :organisme')
            ->setParameter('organisme', $organisme)
            ->addOrderBy('c.intitule', 'ASC')
        ;
        $query = $qb->getQuery();

        return $query->execute();
    }

    // /**
    //  * @return Veille[] Returns an array of Veille objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Veille
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
