<?php


namespace App\Tests\Controller;


class VoteControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testShowIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/vote');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}