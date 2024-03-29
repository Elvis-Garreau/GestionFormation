<?php

namespace App\Repository;

use App\Entity\ModuleFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModuleFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleFormation[]    findAll()
 * @method ModuleFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleFormation::class);
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
    //  * @return ModuleFormation[] Returns an array of ModuleFormation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModuleFormation
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
