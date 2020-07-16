<?php

namespace App\Repository;

use App\Entity\BlogPost;
use App\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    /**
     * @return BlogPost[]
     */
    public function getPostsByLanguageName($languageName, $page = 1, $results = 10)
    {
        $languageRepository = $this->getEntityManager()->getRepository(Language::class);
        $language = $languageRepository->findOneByName($languageName);

        $startIndex = ($page - 1) * $results;

        return  $this->createQueryBuilder('b')
            ->andWhere('b.language = :val')
            ->setParameter('val', $language)
            ->orderBy('b.publishTime', 'DESC')
            ->setFirstResult($startIndex)
            ->setMaxResults($results)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getPageCountByLanguageName($languageName, $resultsPerPage = 10)
    {
        $languageRepository = $this->getEntityManager()->getRepository(Language::class);
        $language = $languageRepository->findOneByName($languageName);

        $count = $this->getTotalByLanguageName($languageName);
        $pages = ceil($count/$resultsPerPage);

        return (int)$pages;
    }

    public function getTotalByLanguageName($languageName)
    {
        $languageRepository = $this->getEntityManager()->getRepository(Language::class);
        $language = $languageRepository->findOneByName($languageName);

        return  $this->createQueryBuilder('b')
            ->andWhere('b.language = :val')
            ->setParameter('val', $language)
            ->select('COUNT(b.language) as num')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    // /**
    //  * @return BlogPost[] Returns an array of BlogPost objects
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
    public function findOneBySomeField($value): ?BlogPost
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
