<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class GetCustomerByIdTest extends ApiTestCase
{
    public function testGetCustomer(): void
    {
        $client = self::createClient();
        $client->request(
            'GET',
            '/foo/kunden/D5F449CE',
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            'id' => 'D5F449CE',
            'name' => 'Meier',
            'vorname' => 'Bertram',
            'geburtsdatum' => '1973-03-06',
            'email' => 'mebe@example.org',
            'vermittlerId' => 1000,
        ]);
    }
}
