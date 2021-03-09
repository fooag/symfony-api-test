<?php

declare(strict_types=1);

namespace App\Tests;

class GetKundenTest extends TestBase
{
    /** @test */
    public function it_gets_kunden_collection_for_vermittler(): void
    {
        $response = $this->createClientWithCredentials()
            ->request('GET', '/foo/kunden');

        $this->assertResponseIsSuccessful();

        // assert
        $data = $response->toArray();
        $this->assertCount(1, $data['hydra:member']);
        $this->assertEquals(1000, $data['hydra:member'][0]['vermittlerId']);

        // or:
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/_data/get_kunden_collection.json',
            $response->getContent()
        );
    }

    // etc.
}
