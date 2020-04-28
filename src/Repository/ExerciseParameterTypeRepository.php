<?php

namespace App\Repository;

use App\Entity\ExerciseParameterType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExerciseParameterType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciseParameterType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciseParameterType[]    findAll()
 * @method ExerciseParameterType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciseParameterTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciseParameterType::class);
    }

    // /**
    //  * @return ExerciseParameterType[] Returns an array of ExerciseParameterType objects
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

    public function findExerciseParameterTypesByQuery(string $query)
    {
        $qb = $this->createQueryBuilder('e');

        return $qb
            ->andWhere($qb->expr()->like('e.name', ':query') )
            ->setParameter('query', $query . '%')
            ->getQuery()
            ->getResult()
            ;
    }
}
