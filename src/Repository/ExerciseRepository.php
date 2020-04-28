<?php

namespace App\Repository;

use App\Entity\Exercise;
use App\Entity\Training;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Exercise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exercise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exercise[]    findAll()
 * @method Exercise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

    public function findExercisesByTraining(Training $training)
    {
        return $this->createQueryBuilder('e')
            ->addSelect('et')
            ->addSelect('ep')
            ->addSelect('ept')
            ->innerJoin('e.exerciseType', 'et')
            ->leftJoin('e.exerciseParameters', 'ep')
            ->leftJoin('ep.type', 'ept')
            ->andWhere('e.training = :training')
            ->setParameter('training', $training)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Exercise[] Returns an array of Exercise objects
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
    public function findOneBySomeField($value): ?Exercise
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
