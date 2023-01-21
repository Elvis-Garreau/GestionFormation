<?php

namespace App\Repository;

use App\Entity\Formateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formateur[]    findAll()
 * @method Formateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formateur::class);
    }

    public function findByOrganisme($organisme)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.organisme = :organisme')
            ->setParameter('organisme', $organisme)
            ->addOrderBy('c.formateur_nom', 'ASC')
            ->orderBy('c.formateur_prenom', 'ASC')
        ;
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function countByOrganisme($organisme)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->where('c.organisme = :organisme')
            ->setParameter('organisme', $organisme)
        ;
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    // /**
    //  * @return Formateur[] Returns an array of Formateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formateur
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
