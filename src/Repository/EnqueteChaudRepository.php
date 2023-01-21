<?php

namespace App\Repository;

use App\Entity\EnqueteChaud;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnqueteChaud|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnqueteChaud|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnqueteChaud[]    findAll()
 * @method EnqueteChaud[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnqueteChaudRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnqueteChaud::class);
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

    public function countByStagiaire($id)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.stagiaire = :stagiaire')
            ->setParameter('stagiaire', $id);

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countByPlanif($planif)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->setParameter('planif', $planif);

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countDureeStage($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.duree_stage = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countSupportFormation($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.support_formation = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countFormateurClair($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.formateur_clair = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countFormateurAdapte($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.formateur_adapte = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countProgrammeClair($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.programme_clair = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countProgrammeAdapte($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.programme_adapte = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countObjectifFormation($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.objectif_formation = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countComprisObjectif($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.compris_objectif = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countExercicesPertinents($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.exercices_pertinents = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countCompetencesAmeliorees($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.competences_ameliorees = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countConditionAccueil($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.condition_accueil = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countApprecieGlobal($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.apprecie_global = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countRecommande($planif, $val)
    {
        $qb = $this->createQueryBuilder('p' )
            ->select('count(p.id)')
            ->where('p.planif = :planif')
            ->andWhere('p.recommande = :val')
            ->setParameters(new ArrayCollection([
                new Parameter('planif', $planif),
                new Parameter('val', $val)
            ]));

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    // /**
    //  * @return EnqueteChaud[] Returns an array of EnqueteChaud objects
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
    public function findOneBySomeField($value): ?EnqueteChaud
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
