<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;

abstract class ApiTestWithLoginTestCase extends ApiTestCase
{
    protected function doLogin(
        Client $client,
        string $user,
        string $password,
    ): string {
        $response = $client->request(
            'POST',
            'foo/login',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => [
                    'email' => $user,
                    'password' => $password,
                ],
            ]
        );
        $this->assertResponseIsSuccessful();
        $json = $response->toArray();
        $this->assertArrayHasKey('token', $json);

        return $json['token'];
    }
}
