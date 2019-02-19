<?php

namespace App\Tests;

use App\Entity\League;
use App\Entity\Team;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeamControllerTest extends FixtureAwareBaseTestCase
{
    public function testCreateTeam()
    {
        $league = $this->em->getRepository(League::class)->findOneBy([]);

        $teamName = "test_team";
        $strip = "test_strip";

        $data = [
            "name" => $teamName,
            "strip" => $strip,
            "league_id" => $league->getId()
        ];

        $response = $this->client->post("teams", [
            'body' => json_encode($data),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getValidToken()
            ]
        ]);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
    }

    public function testUpdateTeam()
    {
        $team = $this->em->getRepository(Team::class)->findOneBy([]);

        $updatedTeamName = "updated_team";
        $updatedTeamStrip = "updated_strip";

        $data = [
            "name" => $updatedTeamName,
            "strip" => $updatedTeamStrip,
            "league_id" => $team->getLeague()->getId()
        ];

        $response = $this->client->put("teams/{$team->getId()}", [
            'body' => json_encode($data),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getValidToken()
            ]
        ]);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }
}
