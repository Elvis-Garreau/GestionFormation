<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findByOrganisme($organisme)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.organisme = :organisme')
            ->setParameter('organisme', $organisme)
            ->addOrderBy('c.nom_societe', 'ASC')
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

    public function search($organisme, $mots)
    {

        if ($mots != null){
            $qb = $this->createQueryBuilder('c')
                ->where('c.organisme = :organisme')
                ->setParameter('organisme', $organisme)
                ;
            $qb->andWhere('MATCH_AGAINST(c.nom_societe, c.representant_nom, c.representant_prenom) AGAINST(:mots boolean)>0')
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
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */



}
