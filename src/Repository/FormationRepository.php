<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    public function findByOrganisme($organisme)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.organisme = :organisme')
            ->setParameter('organisme', $organisme)
            ->addOrderBy('c.nom_formation', 'ASC')
        ;
        $query = $qb->getQuery();

        return $query;
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

    public function search($organisme, $mots)
    {

        if ($mots != null){
            $qb = $this->createQueryBuilder('c')
                ->where('c.organisme = :organisme')
                ->setParameter('organisme', $organisme)
            ;
            $qb->andWhere('MATCH_AGAINST(c.nom_formation) AGAINST(:mots boolean)>0')
                ->setParameter('mots', $mots);
        }else {
            $qb = $this->createQueryBuilder('c')
                ->where('c.organisme = :organisme')
                ->setParameter('organisme', $organisme)
            ;
        }
        $query = $qb->getQuery();

        return $query->getResult();
    }

    // /**
    //  * @return Formation[] Returns an array of Formation objects
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
    public function findOneBySomeField($value): ?Formation
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
