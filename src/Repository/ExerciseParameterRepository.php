<?php

namespace App\Repository;

use App\Entity\ExerciseParameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExerciseParameter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciseParameter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciseParameter[]    findAll()
 * @method ExerciseParameter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciseParameterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciseParameter::class);
    }

    // /**
    //  * @return ExerciseParameter[] Returns an array of ExerciseParameter objects
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
    public function findOneBySomeField($value): ?ExerciseParameter
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
