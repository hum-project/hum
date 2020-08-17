<?php

namespace App\Repository;

use App\Entity\ClientNominalAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientNominalAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientNominalAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientNominalAnswer[]    findAll()
 * @method ClientNominalAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientNominalAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientNominalAnswer::class);
    }

    // /**
    //  * @return ClientNominalAnswer[] Returns an array of ClientNominalAnswer objects
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
    public function findOneBySomeField($value): ?ClientNominalAnswer
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
