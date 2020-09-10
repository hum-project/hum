<?php


namespace App\DataFixtures;


use App\Entity\BlogImage;
use App\Entity\Image;
use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixture extends Fixture implements DependentFixtureInterface
{

    public const IMAGE_1 = 'symbol1';
    public const IMAGE_2 = 'symbol2';
    public const IMAGE_3 = 'symbol3';
    public const BLOG_IMAGE = 'blogImage';

    public function load(ObjectManager $manager)
    {


        $image1 = new Image();
        $image1->setAlt("Example image");
        $image1->setFileName('symbol.png');
        $manager->persist($image1);

        $image2 = new Image();
        $image2->setAlt("Example image");
        $image2->setFileName('symbol.png');
        $manager->persist($image2);

        $image3 = new Image();
        $image3->setAlt("Example image");
        $image3->setFileName('symbol.png');
        $manager->persist($image3);

        $blogImage = new BlogImage();
        $blogImage->setSubtext("Example image is an example image.");
        $blogImage->setOrdering(1);
        $blogImage->setImage($image1);
        $blogImage->setBlogPost($this->getReference(BlogPostFixture::ENGLISH_POST));
        $manager->persist($blogImage);

        $manager->flush();

        $this->addReference(self::IMAGE_1, $image1);
        $this->addReference(self::IMAGE_2, $image2);
        $this->addReference(self::IMAGE_3, $image3);
        $this->addReference(self::BLOG_IMAGE, $blogImage);
    }

    public function getDependencies()
    {
        return array(
            BlogPostFixture::class
        );
    }
}