<?php


namespace App\DataFixtures;


use App\Entity\BlogPost;
use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;

class BlogPostFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    public function load(ObjectManager $manager)
    {
        $post1 = new BlogPost();
        $post1->setTitle("post1");
        $post1->setText("postpost postpost");
        $post1->setEntered(new \DateTime("2020-01-01"));
        $post1->updateSlug();
        $manager->persist($post1);

        $post2 = new BlogPost();
        $post2->setTitle("post2");
        $post2->setText("postpost postpost");
        $post2->setEntered(new \DateTime("2020-01-01"));
        $post2->updateSlug();
        $manager->persist($post2);

        $post3 = new BlogPost();
        $post3->setTitle("post3");
        $post3->setText("postpost postpost");
        $post3->setEntered(new \DateTime("2020-01-01"));
        $post3->updateSlug();
        $manager->persist($post3);

        $post4 = new BlogPost();
        $post4->setTitle("post4");
        $post4->setText("postpost postpost");
        $post4->setEntered(new \DateTime("2020-01-01"));
        $post4->updateSlug();
        $manager->persist($post4);

        $manager->flush();
    }
}