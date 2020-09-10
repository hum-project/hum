<?php


namespace App\DataFixtures;


use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;

class LanguageFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    public const LANGUAGE_SWEDISH = 'Svenska';
    public const LANGUAGE_ENGLISH = 'English';

    public function load(ObjectManager $manager)
    {


        $swedish = new Language();
        $swedish->setName("Svenska");

        $english = new Language();
        $english->setName("English");

        $manager->persist($swedish);
        $manager->persist($english);

        $manager->flush();

        $this->addReference(self::LANGUAGE_SWEDISH, $swedish);
        $this->addReference(self::LANGUAGE_ENGLISH, $english);
    }

}