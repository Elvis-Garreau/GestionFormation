<?php

namespace App\Repository;

use App\Entity\Organisme;
use App\Entity\Planif;
use App\Entity\PlanifSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @method Planif|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planif|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planif[]    findAll()
 * @method Planif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planif::class);
    }

    public function findByOrganisme($organisme)
    {
        $qb = $this->createQueryBuilder('formation')
            ->where('formation.organisme = :organisme')
            ->setParameter('organisme', $organisme)
            ->orderBy('formation.date_debut', 'ASC')
        ;

        return $qb->getQuery()->execute();
    }

    public function findByOrganismeWithSearch($organisme, $search)
    {
        $annee = date('Y');
        $mois = date('m');
        $jour = date('d');

        $date_now = $annee . $mois . $jour;

        $qb = $this->createQueryBuilder('formation')
            ->where('formation.organisme = :organisme')
            ->setParameter('organisme', $organisme)
            ->orderBy('formation.date_debut', 'DESC')
        ;
        if ($search->get('mot')->getData() != null){
            $qb = $qb
                ->join('formation.programme', 'p')
                ->join('formation.client', 'c')
                ->andWhere('MATCH_AGAINST(c.nom_societe, c.representant_nom, c.representant_prenom) AGAINST(:mots boolean)>0')
                ->orWhere('MATCH_AGAINST(p.nom_formation) AGAINST(:mots boolean)>0')
                ->setParameter('mots', $search->get('mot')->getData());
        }

        if ($search->get('periode')->getData() != null) {
            if ($search->get('periode')->getData() == 1) {
                $qb = $qb
                    ->andWhere('formation.date_fin < :date_now')
                    ->setParameter('date_now', $date_now)
                ;
            }
            else if ($search->get('periode')->getData() == 2) {
                $qb = $qb
                    ->andWhere('formation.date_debut >= :date_now')
                    ->setParameter('date_now', $date_now)
                    ->orderBy('formation.date_debut', 'ASC')
                ;
            }
        }

        return $qb->getQuery();
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
            $qb = $this->createQueryBuilder('f')
                ->join('f.programme', 'p')
                ->join('f.client', 'c')
                ->where('f.organisme = :organisme')
                ->setParameter('organisme', $organisme)
            ;
            $qb->andWhere('MATCH_AGAINST(c.nom_societe, c.representant_nom, c.representant_prenom) AGAINST(:mots boolean)>0')
                ->orWhere('MATCH_AGAINST(p.nom_formation) AGAINST(:mots boolean)>0')
                ->setParameter('mots', $mots);
        }else {
            $qb = $this->createQueryBuilder('f')
                ->where('f.organisme = :organisme')
                ->setParameter('organisme', $organisme)
            ;
        }
        $query = $qb->getQuery();

        return $query;
    }

    // /**
    //  * @return Planif[] Returns an array of Planif objects
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
    public function findOneBySomeField($value): ?Planif
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
