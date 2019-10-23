<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testPosts()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/posts');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(51, $crawler->filter('tr')->count());
    }
}
