<?php

namespace App\Tests\Controller;

use App\Entity\League;
use App\Tests\FixtureAwareBaseTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class LeagueTeamsControllerTest extends FixtureAwareBaseTestCase
{
    public function testGetLeagueTeams()
    {
        $league = $this->em->getRepository(League::class)->findOneBy([]);

        $response = $this->client->get("leagues/{$league->getId()}/teams", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getValidToken()
            ]
        ]);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testGetNonExistentLeagueTeams()
    {
        $response = $this->client->get("leagues/170/teams", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getValidToken()
            ]
        ]);

        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
