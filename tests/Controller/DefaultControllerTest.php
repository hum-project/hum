<?php


namespace App\Tests\Controller;


class DefaultControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testShowRoot() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowNewsPosts() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertNotEmpty($crawler->filter('.news-list'),
            'Admin page should contain a section with a html class \'news-list\'');
    }

}