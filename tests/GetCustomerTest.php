<?php

declare(strict_types=1);

namespace App\Tests;

class GetCustomerTest extends ApiTestWithLoginTestCase
{
    public function testGetCustomer(): void
    {
        $client = self::createClient();
        $token = $this->doLogin($client, 'mfindel@vp-felder.de', 'hommes');

        $client->request(
            'GET',
            '/foo/kunden',
            ['auth_bearer' => $token]
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            'hydra:totalItems' => 1,
            'hydra:member' => [
                [
                    'id' => 'D5F449CE',
                    'name' => 'Meier',
                    'vorname' => 'Bertram',
                    'geburtsdatum' => '1973-03-06',
                    'email' => 'mebe@example.org',
                    'vermittlerId' => 1000,
                ],
            ],
        ]);
    }
}
