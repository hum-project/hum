<?php

namespace App\Repository;

use App\Entity\Argument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Argument|null find($id, $lockMode = null, $lockVersion = null)
 * @method Argument|null findOneBy(array $criteria, array $orderBy = null)
 * @method Argument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArgumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Argument::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.translation is NULL')
            ->andWhere('a.parent is NULL')
            ->getQuery()
            ->getResult()
            ;

    }

    // /**
    //  * @return Argument[] Returns an array of Argument objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Argument
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
