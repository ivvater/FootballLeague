<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\JsonResponse;

class AuthorisationControllerTest extends FixtureAwareBaseTestCase
{
    public function testGenerateJwtToken()
    {
        $data = [
            "email" => self::TEST_USER_EMAIL,
            "password" => self::TEST_USER_PASSWORD,
        ];

        $response = $this->client->post("authorisation", [
            'body' => json_encode($data),
        ]);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }
}
