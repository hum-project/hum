<?php


namespace App\Tests\Repository;


use App\Entity\BlogPost;
use App\Entity\Language;
use App\Repository\BlogPostRepository;

class BlogPostRepositoryTest extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCountPages()
    {

        $total = $this->entityManager
            ->getRepository("App\Entity\BlogPost")
            ->getTotalByLanguageName("English");
        ;
        $this->assertNotEmpty($total);

        $resultsPerPage = 10;
        $pages = $this->entityManager
            ->getRepository("App\Entity\BlogPost")
            ->getPageCountByLanguageName("English");
        ;
        $expected = (int)ceil($total/$resultsPerPage);

        $this->assertEquals($expected, $pages);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}