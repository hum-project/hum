<?php

namespace App\Repository;

use App\Entity\ClientAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientAnswer[]    findAll()
 * @method ClientAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientAnswer::class);
    }

    // /**
    //  * @return ClientAnswer[] Returns an array of ClientAnswer objects
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
    public function findOneBySomeField($value): ?ClientAnswer
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
