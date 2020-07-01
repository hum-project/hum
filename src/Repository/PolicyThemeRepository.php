<?php

namespace App\Repository;

use App\Entity\PolicyTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PolicyTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method PolicyTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method PolicyTheme[]    findAll()
 * @method PolicyTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PolicyThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PolicyTheme::class);
    }

    // /**
    //  * @return PolicyTheme[] Returns an array of PolicyTheme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PolicyTheme
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
