<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;

/**
 * cf. https://api-platform.com/docs/core/testing/
 */
abstract class TestBase extends ApiTestCase
{
    private $token;

    protected const BASE_URL = 'http://web:8080';
    protected const AUTH_URL = '/authentication_token';
    protected const DEFAULT_USER = 'mfindel@vp-felder.de';
    protected const DEFAULT_USER_PASS = 'hommes';

    protected static $defaultHeaders = [
        'Content-Type' => 'application/json'
    ];

    public function setUp(): void
    {
        self::bootKernel();
    }

    protected function createUnauthenticatedClient(): Client
    {
        return self::createClient([], [
            'base_uri' => self::BASE_URL,
            'headers' => self::$defaultHeaders
        ]);
    }

    protected function createClientWithCredentials($token = null): Client
    {
        $token = $token ?: $this->getToken();

        return static::createClient([
            'base_uri' => self::BASE_URL,
        ], [
            'headers' => array_merge(
                self::$defaultHeaders,
                ['Authorization' => 'Bearer '. $token]
            )
        ]);
    }

    /**
     * Use other credentials if needed.
     */
    protected function getToken(array $body = []): string
    {
        if ($this->token) {
            return $this->token;
        }

        // do
        $response = $this->createUnauthenticatedClient()->request(
            'POST',
            self::AUTH_URL,
            [
                'json' => $body ?: [
                    'email' => self::DEFAULT_USER,
                    'password' => self::DEFAULT_USER_PASS,
                ]
            ]
        );

        $this->assertResponseIsSuccessful();
        $data = $response->toArray();
        $this->assertArrayHasKey('token', $data);
        $this->token = $data['token'];

        return $this->token;
    }
}
