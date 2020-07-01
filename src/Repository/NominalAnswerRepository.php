<?php

namespace App\Repository;

use App\Entity\NominalAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NominalAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method NominalAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method NominalAnswer[]    findAll()
 * @method NominalAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NominalAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NominalAnswer::class);
    }

    // /**
    //  * @return NominalAnswer[] Returns an array of NominalAnswer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NominalAnswer
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
