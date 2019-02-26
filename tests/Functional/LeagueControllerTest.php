<?php

namespace App\Tests\Controller;

use App\Entity\League;
use App\Tests\FixtureAwareBaseTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class LeagueControllerTest extends FixtureAwareBaseTestCase
{

    public function testDeleteLeague(): void
    {
        $league = $this->em->getRepository(League::class)->findOneBy([]);

        $response = $this->client->delete("leagues/{$league->getId()}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getValidToken()
            ]
        ]);

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
