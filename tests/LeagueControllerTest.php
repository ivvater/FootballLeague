<?php

namespace App\Tests;

use App\Entity\League;
use Symfony\Component\HttpFoundation\JsonResponse;

class LeagueControllerTest extends FixtureAwareBaseTestCase
{
    public function testDeleteLeague()
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
