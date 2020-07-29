<?php


namespace App\Tests\Controller;


class HumControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testShowIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hum');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowAddPost() {
        $client = static::createClient();

        $client->request('GET', 'hum/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddFormHasSubmitButton()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hum/add');
        $this->assertNotEmpty($crawler->filter('button[type="submit"]'));
    }

}