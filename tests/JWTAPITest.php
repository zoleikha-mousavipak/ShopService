<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class JWTAPITest extends WebTestCase
{    
    /**
     * Create a client with a Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'mac94@moen.com', $password = 'secret')
    {
        $client = static::createClient();
        $client->request(
        'POST',
        '/api/login_check',
        [],
        [],
        ['CONTENT_TYPE' => 'application/json'],
        json_encode([
            '_username' => $username,
            '_password' => $password,
        ])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        
        return $client;
    }

    /**
     * test get authenticated user
    */
    public function testGetUser()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/user');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful();
    }

}