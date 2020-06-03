<?php

namespace App\Tests\Util;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testGetAverage()
    {
        $client = static::createClient();

        $client->request('GET', '/api/average?uuid=31d0a02d-ec54-46dd-b264-350591e3429b');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('score', $data);
        $this->assertEquals('6.25', $data['score']);

//        $this->assertEquals('6.25', $client->getResponse()->getContent());

        $client->request('GET', '/api/average?uuid=811cdddb-9acc-4652-93ce-2bdc25d46028');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
//        $this->assertEquals('7.5', $client->getResponse()->getContent());
        $this->assertArrayHasKey('score', $data);
        $this->assertEquals('7.5', $data['score']);

        $client->request('GET', '/api/average?id=1');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        $client->request('GET', '/api/average?uuid=1');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testGetReviews()
    {
        $client = static::createClient();

        $client->request('GET', '/api/reviews?uuid=31d0a02d-ec54-46dd-b264-350591e3429b');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        $this->assertEquals('[{"id":"1","uuid"="31d0a02d-ec54-46dd-b264-350591e3429b","hotel_id":"1","score":"10","comment":"Very nice stay"},{"id":"2","uuid":"31d0a02d-ec54-46dd-b264-350591e3429b","hotel_id":"1","score":"5","comment":"Average"},{"id":"3","uuid":"31d0a02d-ec54-46dd-b264-350591e3429b","score":"9","comment":"Very nice stay, I enjoyed it a lot."},{"id":"4","uuid":"31d0a02d-ec54-46dd-b264-350591e3429b","score":"1","comment":"Worst experience ever."}]',
//            $client->getResponse()->getContent());
        $this->assertCount(4, json_decode($client->getResponse()->getContent()));

        $client->request('GET', '/api/reviews?uuid=811cdddb-9acc-4652-93ce-2bdc25d46028');
        $this->assertCount(2, json_decode($client->getResponse()->getContent()));

//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        $this->assertEquals('[{"id":"5","hotel_id":"2","score":"5","comment":"The receptionist was not smiling."},{"id":"6","hotel_id":"2","score":"10","comment":"Very nice stay, the reception was really fast."}]', $client->getResponse()->getContent());
    }

    public function testGetHotels()
    {
        $client = static::createClient();

        $client->request('GET', '/api/hotels');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        $this->assertEquals('[{"id":"1","name":"Hotel Alexanderplatz","address":"Alexanderplatz 1, 10409, Berlin"},{"id":"2","name":"Hotel Alexanderplatz","address":"Alexanderplatz 1, 10409, Berlin"},{"id":"3","name":"Hotel Alexanderplatz","address":"Alexanderplatz 1, 10409, Berlin"},{"id":"4","name":"Hotel Alexanderplatz","address":"Alexanderplatz 1, 10409, Berlin"},{"id":"5","name":"Hotel Alexanderplatz","address":"Alexanderplatz 1, 10409, Berlin"}]', $client->getResponse()->getContent());
        $this->assertCount(5, json_decode($client->getResponse()->getContent()));
    }

    public function testWidget()
    {
        $client = static::createClient();
        $client->request('GET', '/widget/811cdddb-9acc-4652-93ce-2bdc25d46028');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $client->request('GET', '/widget/811cdddb-9acc-4652-93ce-2bdc25d46028.js');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('text/javascript; charset=UTF-8', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('iframe', $client->getResponse()->getContent());
    }


}
