<?php

namespace App\Repository;

use App\Entity\BlogImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogImage[]    findAll()
 * @method BlogImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogImage::class);
    }

    // /**
    //  * @return BlogImage[] Returns an array of BlogImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogImage
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
