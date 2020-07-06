<?php


namespace App\Tests\Controller;


class BlogControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testShowNews() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/news');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(1, $crawler->filter('.news')->count());
    }

    public function testShowAddPost() {
        $client = static::createClient();

        $client->request('GET', 'news/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}