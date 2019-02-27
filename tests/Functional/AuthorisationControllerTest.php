<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\FixtureAwareBaseTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthorisationControllerTest extends FixtureAwareBaseTestCase
{
    /**
     * @return array
     */
    public function invalidCredentialsDataProvider(): array
    {
        return [
            [
                null,
                self::TEST_USER_PASSWORD
            ],
            [
                'invalid@email.com',
                self::TEST_USER_PASSWORD
            ],
            [
                self::TEST_USER_EMAIL,
                null
            ],
        ];
    }

    public function testGenerateJwtTokenWithValidCredentials(): void
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

    /**
     * @dataProvider invalidCredentialsDataProvider
     * @param string $email
     * @param string $password
     */
    public function testGenerateJwtTokenWithInvalidCredentials(?string $email, ?string $password): void
    {
        $data = [
            'email' => $email,
            "password" => $password
        ];

        $response = $this->client->post("authorisation", [
            'body' => json_encode($data),
        ]);

        $this->assertEquals(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}
