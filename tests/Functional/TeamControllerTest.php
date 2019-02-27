<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\League;
use App\Entity\Team;
use App\Tests\FixtureAwareBaseTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeamControllerTest extends FixtureAwareBaseTestCase
{
    /**
     * @return array
     */
    public function invalidDataCreateTeamDataProvider(): array
    {
        return [
            [
                [
                    "name" => 'test_team',
                    "strip" => '',
                    "league_id" => 1
                ]
            ],
            [
                [
                    "name" => '',
                    "strip" => 'test_strip',
                    "league_id" => 1
                ]
            ],
            [
                [
                    "name" => null,
                    "strip" => '',
                    "league_id" => 1
                ]
            ],
            [
                [
                    "name" => 'test_team',
                    "strip" => 'test_strip',
                    "league_id" => null
                ]
            ],
        ];
    }

    public function testCreateTeamWithValidData()
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

    /** @dataProvider invalidDataCreateTeamDataProvider
     * @param array $data
     */
    public function testCreateTeamWithInvalidData(array $data)
    {
        $response = $this->client->post("teams", [
            'body' => json_encode($data),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getValidToken()
            ]
        ]);

        $this->assertEquals(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
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
