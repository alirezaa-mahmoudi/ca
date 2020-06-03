<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChainControllerTest extends WebTestCase
{
    public function testChain()
    {
        $client = static::createClient();
        $client->request('GET', '/api/chain');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(2, json_decode($client->getResponse()->getContent()));
    }
    public function testChainId()
    {
        $client = static::createClient();
        $client->request('GET', '/api/chain/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(5, json_decode($client->getResponse()->getContent()));

        $client->request('GET', '/api/chain/id');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

    }
}
