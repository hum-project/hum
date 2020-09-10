<?php


namespace App\DataFixtures;


use App\Entity\Institution;
use App\Entity\Policy;
use App\Entity\PolicyTheme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PolicyFixture extends Fixture implements DependentFixtureInterface
{
    protected const LOREM = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean viverra turpis mauris, ac blandit turpis condimentum nec. Curabitur ligula enim, suscipit ultrices lorem vitae, posuere imperdiet justo.";

    public function load(ObjectManager $manager)
    {
        $english = $this->getReference(LanguageFixture::LANGUAGE_ENGLISH);
        $swedish = $this->getReference(LanguageFixture::LANGUAGE_SWEDISH);

        $theme1 = new PolicyTheme();
        $theme1->setText(self::LOREM);
        $theme1->setTitle("Example 1");
        $theme1->setSymbol($this->getReference(ImageFixture::IMAGE_1));
        $theme1->setLanguage($english);

        $theme2 = new PolicyTheme();
        $theme2->setText(self::LOREM);
        $theme2->setTitle("Exempel 1");
        $theme2->setSymbol($this->getReference(ImageFixture::IMAGE_2));
        $theme2->setLanguage($swedish);

        $policy1 = new Policy();
        $policy1->setTitle("Example title");
        $policy1->setText(self::LOREM);
        $policy1->setArgument($this->getReference(ArgumentFixture::ARGUMENT_1));
        $policy1->setPolicyTheme($theme1);
        $policy1->setSource('www.example.com');
        $policy1->setLanguage($english);
        $theme1->addPolicy($policy1);
        $manager->persist($policy1);

        $policy2 = new Policy();
        $policy2->setTitle("Exampel titel");
        $policy2->setText(self::LOREM);
        $policy2->setArgument($this->getReference(ArgumentFixture::ARGUMENT_2));
        $policy2->setPolicyTheme($theme2);
        $policy2->setSource('www.example.com');
        $policy2->setLanguage($swedish);
        $theme2->addPolicy($policy2);
        $manager->persist($policy2);

        $institution1 = new Institution();
        $institution1->setLanguage($english);
        $institution1->setPolicyTheme($theme1);
        $institution1->setText(self::LOREM);
        $institution1->setName("Institution 1");
        $theme1->addInstitution($institution1);
        $manager->persist($institution1);

        $institution2 = new Institution();
        $institution2->setLanguage($swedish);
        $institution2->setPolicyTheme($theme2);
        $institution2->setText(self::LOREM);
        $institution2->setName("Institution 2");
        $theme2->addInstitution($institution2);
        $manager->persist($institution2);

        $manager->persist($theme1);
        $manager->persist($theme2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LanguageFixture::class,
            ImageFixture::class,
            ArgumentFixture::class
        );
    }
}