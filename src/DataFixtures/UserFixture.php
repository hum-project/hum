<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("test@femtearenan.se");
        $user->setUsername("test");
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$RjR1eVp5QkNTL08uaU1RUA$6LGHoaMJO6PEljMwzVb/1uiFFKLNQPS4svEmAWk67Tg');
        $manager->persist($user);

        $user0 = new User();
        $user0->setEmail("fix0@example.com");
        $user0->setUsername("fix0");
        $user0->setPassword("example0");
        $manager->persist($user0);

        $user1 = new User();
        $user1->setEmail("user1@example.com");
        $user1->setUsername("user");
        $user1->setPassword("user1");
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail("user2@example.com");
        $user2->setUsername("user2");
        $user2->setPassword("user2");
        $manager->persist($user2);

        $user3 = new User();
        $user3->setEmail("user3@example.com");
        $user3->setUsername("user3");
        $user3->setPassword("example0");
        $manager->persist($user3);


        $manager->flush();
    }
}
