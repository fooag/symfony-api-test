<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;

class JwtAuthTest extends TestBase
{
    /** @test */
    public function it_can_obtain_an_authenticated_token(): void
    {
        $client = $this->createUnauthenticatedClient();

        // retrieve a token
        $response = $client->request('POST', '/authentication_token', [
            'headers' => self::$defaultHeaders,
            'json'    => [
                'email'    => self::DEFAULT_USER,
                'password' => self::DEFAULT_USER_PASS,
            ],
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $json);

        // test not authorized
        $client->request('GET', '/foo/kunden');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        // test authorized
        $client->request('GET', '/foo/kunden', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();
    }

    /** @test */
    public function it_fails_with_invalid_credentials(): void
    {
        $client = $this->createUnauthenticatedClient();

        $client->request('POST', self::AUTH_URL, [
                'headers' => ['Content-Type' => 'application/json'],
                'json'    => [
                    'email'    => self::DEFAULT_USER,
                    'password' => 'invalid',
                ],
            ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_fails_with_inactive_vermittler(): void
    {
        $client = $this->createUnauthenticatedClient();

        $client->request('POST', self::AUTH_URL, [
            'headers' => ['Content-Type' => 'application/json'],
            'json'    => [
                'email'    => 'chauser@vp-felder.de',
                'password' => 'hauser',
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}
