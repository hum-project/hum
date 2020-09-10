<?php


namespace App\Tests\Controller;


class PolicyControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testShowIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/policy');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowAdd() {
        $client = static::createClient();

        $client->request('GET', 'policy/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddFormHasSubmitButton()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/policy/add');
        $this->assertNotEmpty($crawler->filter('button[type="submit"]'));
    }

}