<?php


namespace App\Tests\Controller;


class PolicyThemeControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testShowIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/theme');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowAddPost() {
        $client = static::createClient();

        $client->request('GET', 'theme/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddFormHasSubmitButton()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/theme/add');
        $this->assertNotEmpty($crawler->filter('button[type="submit"]'));
    }

}