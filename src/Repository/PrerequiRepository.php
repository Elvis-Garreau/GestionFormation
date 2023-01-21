<?php

namespace App\Repository;

use App\Entity\Prerequi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prerequi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prerequi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prerequi[]    findAll()
 * @method Prerequi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrerequiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prerequi::class);
    }

    public function findAllByFormation($id)
    {
        $qb = $this->createQueryBuilder('p' )
            ->where('p.formation = :formation')
            ->setParameter('formation', $id)
            ->addOrderBy('p.id', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();
    }

    // /**
    //  * @return Prerequi[] Returns an array of Prerequi objects
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
    public function findOneBySomeField($value): ?Prerequi
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
