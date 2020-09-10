<?php


namespace App\DataFixtures;


use App\Entity\Argument;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArgumentFixture extends Fixture implements DependentFixtureInterface
{
    protected const LOREM = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean viverra turpis mauris, ac blandit turpis condimentum nec. Curabitur ligula enim, suscipit ultrices lorem vitae, posuere imperdiet justo.";

    public const ARGUMENT_1 = 'argument 1';
    public const ARGUMENT_2 = 'argument 2';

    public function load(ObjectManager $manager)
    {
        $english = $this->getReference(LanguageFixture::LANGUAGE_ENGLISH);
        $swedish = $this->getReference(LanguageFixture::LANGUAGE_SWEDISH);

        $argument1 = new Argument();
        $argument1->setLanguage($english);
        $argument1->setText(self::LOREM);
        $argument1->setSide('Pro');

        $this->addDescendents($argument1, 4);

        $argument2 = new Argument();
        $argument2->setLanguage($swedish);
        $argument2->setText(self::LOREM);
        $argument2->setSide('Pro');

        $this->addDescendents($argument2, 4);

        $arguments = array();
        $arguments[] = $argument1;
        array_push($arguments, ...$argument1->getDescendants());
        array_push($arguments, $argument2);
        array_push($arguments, ...$argument2->getDescendants());

        foreach ($arguments as $arg) {
            $manager->persist($arg);
        }

        $this->addReference(self::ARGUMENT_1, $argument1);
        $this->addReference(self::ARGUMENT_2, $argument2);

        $manager->flush();
    }


    protected function addDescendents(Argument $argument, $levels) {
        if ($levels > 0) {

            $side = "Con";
            if ($argument->getSide() === 'Con') {
                $side = "Pro";
            }

            $child = new Argument();
            $child->setSide($side);
            $child->setText(self::LOREM);
            $child->setLanguage($argument->getLanguage());

            $argument->setChild($child);
            $child->setParent($argument);

            $levels--;
            return $this->addDescendents($child, $levels);
        }

        return $argument;
    }

    public function getDependencies()
    {
        return array(
            LanguageFixture::class,
        );
    }
}