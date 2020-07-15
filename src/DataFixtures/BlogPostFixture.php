<?php


namespace App\DataFixtures;


use App\Entity\BlogPost;
use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;

class BlogPostFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    public function load(ObjectManager $manager)
    {
        $english = new Language();
        $english->setName("English");
        $manager->persist($english);

        $svenska = new Language();
        $svenska->setName("Svenska");
        $manager->persist($svenska);

        $post1 = new BlogPost();
        $post1->setTitle("Some great news");
        $post1->setText("These are some great news! |1|");
        $post1->setEntered(new \DateTime("2020-01-01"));
        $post1->updateSlug();
        $post1->setLanguage($english);
        $manager->persist($post1);

        $post2 = new BlogPost();
        $post2->setTitle("Några fantastiska nyheter");
        $post2->setText("Det här är jättebra nyheter! |1|");
        $post2->setEntered(new \DateTime("2020-01-01"));
        $post2->updateSlug();
        $post2->setParent($post1);
        $post2->setLanguage($svenska);
        $post1->addBlogPost($post2);
        $manager->persist($post2);

        $manager->flush();
    }
}