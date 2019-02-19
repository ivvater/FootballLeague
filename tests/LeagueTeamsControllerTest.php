<?php

namespace App\Tests;

use App\Entity\League;
use Symfony\Component\HttpFoundation\JsonResponse;

class LeagueTeamsControllerTest extends FixtureAwareBaseTestCase
{
    public function testDeleteLeague()
    {
        $league = $this->em->getRepository(League::class)->findOneBy([]);

        $response = $this->client->get("leagues/{$league->getId()}/teams", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getValidToken()
            ]
        ]);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }
}
