<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to URL shortener', $crawler->filter('#container h1')->text());
    }

    public function testShortenUrl()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Shorten it!')->form();

        $form['appbundle_url[fullUrl]'] = 'http://bbc.co.uk';

        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(
            'Voila! Here\'s your short url',
            $client->getResponse()->getContent()
        );
    }
}
