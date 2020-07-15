<?php


namespace App\Tests\Controller;


class BlogControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testShowNews() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/news');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('.news')->count());
    }

    public function testShowAddPost() {
        $client = static::createClient();

        $client->request('GET', 'news/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddNewsHasSubmitButton()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/news/add');
        $this->assertNotEmpty($crawler->filter('button[type="submit"]'));
    }

    public function testControllerFillsInDefaultValues()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/news/add');
        $client->submitForm('Submit', [
            'blog_post[title]' => 'test',
            'blog_post[text]' => 'test text',
            'blog_post[publishTime][date][month]' => '7',
            'blog_post[publishTime][date][day]' => '1',
            'blog_post[publishTime][date][year]' => '2020',
            'blog_post[publishTime][time][hour]' => '8',
            'blog_post[publishTime][time][minute]' => '15'
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}