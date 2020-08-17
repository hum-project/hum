<?php

namespace App\Repository;

use App\Entity\ClientContinuousAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientContinuousAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientContinuousAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientContinuousAnswer[]    findAll()
 * @method ClientContinuousAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientContinuousAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientContinuousAnswer::class);
    }

    // /**
    //  * @return ClientContinuousAnswer[] Returns an array of ClientContinuousAnswer objects
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

    /*
    public function findOneBySomeField($value): ?ClientContinuousAnswer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
