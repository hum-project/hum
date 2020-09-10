<?php


namespace App\DataFixtures;


use App\Entity\BlogPost;
use App\Entity\Language;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BlogPostFixture extends \Doctrine\Bundle\FixturesBundle\Fixture implements DependentFixtureInterface
{
    public const ENGLISH_POST = 'English post';
    public const SWEDISH_POST = 'Svenskt inlägg';

    public function load(ObjectManager $manager)
    {
        $english = $this->getReference(LanguageFixture::LANGUAGE_ENGLISH);
        $svenska = $this->getReference(LanguageFixture::LANGUAGE_SWEDISH);

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

        for ($i = 0; $i < 50; $i++) {
            $post = $this->generatePost("Some new news " . $i, $english);
            $child = $this->generatePost("Några nyheter " . $i, $svenska);
            $child->setParent($post);
            $post->addBlogPost($child);

            $manager->persist($post);
            $manager->persist($child);
        }


        $manager->flush();

        $this->addReference(self::ENGLISH_POST, $post1);
        $this->addReference(self::SWEDISH_POST, $post2);
    }

    public function generatePost($title, Language $language) : BlogPost
    {
        $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus porta eros a nulla vestibulum viverra. In ex velit, cursus ut efficitur non, sollicitudin id nisl. Mauris fermentum leo id nisi tempor, in euismod massa cursus. In facilisis et sapien non aliquet. Pellentesque pharetra dictum arcu a scelerisque. Quisque eget volutpat tellus. Aenean non lacus nulla. Aliquam ut velit vitae dui euismod dictum porttitor et massa. Sed volutpat lobortis leo lobortis porttitor. Donec nisi enim, interdum in enim non, posuere luctus magna. Suspendisse non enim quis eros gravida tincidunt eleifend vel urna. Aliquam cursus nisi ut consequat mollis. Nullam cursus, nulla sed rhoncus tempor, nisl tellus congue orci, sit amet tincidunt dui elit sit amet quam.

Vivamus placerat sagittis tellus, id vulputate justo dictum non. Fusce laoreet at massa auctor convallis. In fermentum suscipit sapien, sit amet pharetra nisi. In vitae leo arcu. Nullam faucibus, dolor imperdiet sollicitudin placerat, nibh tortor vehicula enim, vel semper leo lectus eget felis. Vestibulum porttitor lacus eget dapibus cursus. Morbi varius leo dolor, eu molestie purus posuere in. Proin et mauris vehicula, dictum nisi quis, feugiat massa. Praesent nibh mauris, imperdiet eget hendrerit vitae, ultricies at enim. Nulla velit dui, vestibulum eget mollis sed, interdum tincidunt lorem. Morbi aliquet nisl a dolor feugiat laoreet.

Pellentesque porttitor, elit in iaculis tempor, purus augue laoreet justo, eget faucibus dui est at purus. Integer ac faucibus purus, nec gravida nunc. In tempor, ex sed auctor blandit, diam libero ullamcorper elit, sed pulvinar lectus erat et risus. Donec quis faucibus elit, tempus aliquam arcu. Vestibulum tempus arcu eu auctor ultricies. Ut laoreet, risus in laoreet auctor, mauris odio egestas tortor, eget pretium diam justo ac augue. Nullam sollicitudin rhoncus lorem, vitae aliquam justo tristique aliquam. Sed ut odio quis tellus tincidunt facilisis eu vel quam. Mauris semper, dui eleifend ornare congue, libero felis porta neque, in consectetur nulla urna sed sapien.

Praesent ut lectus porttitor, porta orci nec, porta eros. Integer id tincidunt tortor. Morbi volutpat, odio nec ultrices mattis, turpis arcu finibus nunc, id interdum risus felis feugiat leo. Fusce vel vehicula nisi. Ut id ipsum vel tellus sollicitudin facilisis. Proin luctus, felis et semper gravida, nulla justo cursus orci, sed pellentesque purus diam at sapien. Donec in pulvinar mauris. Donec ultricies volutpat enim, quis consequat velit luctus id. In in tortor et eros pretium dictum. Integer consectetur arcu quis porttitor varius. Suspendisse pretium a odio et hendrerit. Maecenas sodales ligula a pretium vehicula. Vivamus sit amet placerat diam, nec malesuada orci. Donec lacinia, metus vel porttitor dignissim, risus nisl pellentesque arcu, a iaculis magna enim quis nisl.

Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla facilisi. Proin ultricies lobortis nulla ut varius. Aliquam malesuada est ut lectus posuere, quis hendrerit sem ultricies. Mauris commodo felis nulla, quis lacinia purus ullamcorper a. Sed venenatis maximus sodales. Curabitur erat mauris, faucibus id facilisis in, efficitur vitae nisl. Nunc ultricies ipsum venenatis diam consequat tempor.";

        $post = new BlogPost();
        $post->setTitle($title);

        $post->setText($lorem);
        $post->setEntered(new \DateTime("2020-01-01"));
        $post->updateSlug();
        $post->setLanguage($language);

        return $post;
    }

    public function getDependencies()
    {
        return array(
            LanguageFixture::class,
        );
    }
}