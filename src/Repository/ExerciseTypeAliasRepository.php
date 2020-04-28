<?php

namespace App\Repository;

use App\Entity\ExerciseTypeAlias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExerciseTypeAlias|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciseTypeAlias|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciseTypeAlias[]    findAll()
 * @method ExerciseTypeAlias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciseTypeAliasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciseTypeAlias::class);
    }

    // /**
    //  * @return ExerciseTypeAlias[] Returns an array of ExerciseTypeAlias objects
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
    public function findOneBySomeField($value): ?ExerciseTypeAlias
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
