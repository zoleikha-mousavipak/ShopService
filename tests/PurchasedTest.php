<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchasedTest extends WebTestCase
{
    /**
     * @covers get Purchased Products
     */
    public function testGetPurchasedProducts()
    {
        $client = static::createClient();

        $client->request('GET', '/api/user/products', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers create Purchase
     */
    public function testCreatePurchase()
    {
        $client = static::createClient();

        // Replace '16' with the actual product ID you want to test
        $data = ['product_id' => '16'];

        $client->request('POST', '/api/user/products', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers delete Purchase
     */
    public function testDeletePurchase()
    {
        $client = static::createClient();

        // Replace 'traktor-kontrol-z2' with the actual sku you want to test
        $client->request('DELETE', '/api/user/products/traktor-kontrol-z2');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful();
    }
}