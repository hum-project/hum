<?php

namespace App\Repository;

use App\Entity\OrdinalAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrdinalAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdinalAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdinalAnswer[]    findAll()
 * @method OrdinalAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdinalAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdinalAnswer::class);
    }

    // /**
    //  * @return OrdinalAnswer[] Returns an array of OrdinalAnswer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrdinalAnswer
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
