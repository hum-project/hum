<?php


namespace App\Tests\Controller;


class ImageControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testShowAddPost() {
        $client = static::createClient();

        $client->request('GET', 'image/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddNewsHasSubmitButton()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/image/add');
        $this->assertNotEmpty($crawler->filter('button[type="submit"]'));
    }

}