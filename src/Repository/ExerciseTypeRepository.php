<?php

namespace App\Repository;

use App\Entity\ExerciseType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExerciseType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciseType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciseType[]    findAll()
 * @method ExerciseType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciseTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciseType::class);
    }

    // /**
    //  * @return ExerciseType[] Returns an array of ExerciseType objects
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

    public function findExerciseTypesByQuery(string $query)
    {
        $qb = $this->createQueryBuilder('e');

        return $qb
            ->andWhere($qb->expr()->like('e.name', ':query') )
//            В setParameter расшифровывается $query используемое выше(слово вводимое в input + %(т.к. используется like))
            ->setParameter('query', $query . '%')
            ->getQuery()
            ->getResult()
        ;
    }

}
