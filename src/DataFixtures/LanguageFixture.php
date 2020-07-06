<?php


namespace App\DataFixtures;


use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;

class LanguageFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    public function load(ObjectManager $manager)
    {
        $english = new Language();
        $english->setName("English");
        $manager->persist($english);

        $svenska = new Language();
        $svenska->setName("Svenska");
        $manager->persist($svenska);

        $manager->flush();
    }
}