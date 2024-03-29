<?php

namespace App\Repository;

use App\Entity\Dates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dates|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dates|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dates[]    findAll()
 * @method Dates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dates::class);
    }

    public function findAllByPlanif($id)
    {
        $qb = $this->createQueryBuilder('p' )
            ->where('p.planif = :planif')
            ->setParameter('planif', $id)
            ->addOrderBy('p.id', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();
    }

    // /**
    //  * @return Dates[] Returns an array of Dates objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dates
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
