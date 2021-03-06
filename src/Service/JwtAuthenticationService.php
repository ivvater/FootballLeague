<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\NotAuthorisedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class JwtAuthenticationService
{
    private $jwtSecret;

    const LIFE_TIME = 60 * 15;

    /**
     * JwtAuthenticationService constructor.
     * @param string $jwtSecret
     * @codeCoverageIgnore
     */
    public function __construct(string $jwtSecret)
    {
        $this->jwtSecret = $jwtSecret;
    }

    /**
     * Generate jwt token by User request
     *
     * @param User $user
     * @return string
     */
    public function generateToken(User $user): string
    {
        $issuedAt = time();
        $secondsValid = self::LIFE_TIME;
        $tokenValidTill = $issuedAt + $secondsValid;
        $meta = [
            'issuedAt' => $issuedAt,
            'validTill' => $tokenValidTill
        ];
        $body = [
            'email' => $user->getEmail(),
        ];

        $meta64 = base64_encode(json_encode($meta));
        $body64 = base64_encode(json_encode($body));
        $payload = "$meta64.$body64";
        $jwt = $payload . '.' . hash_hmac('SHA256', $payload, $this->jwtSecret);

        return $jwt;
    }

    /**
     * Validate given jwt token
     *
     * @param string $token
     */
    public function validateToken(string $token): void
    {
        $parts = explode('.', $token);
        $body = "$parts[0].$parts[1]";
        if (hash_hmac('SHA256', $body, $this->jwtSecret) !==  $parts[2]) {
            throw new NotAuthorisedException('Authorisation required', JsonResponse::HTTP_UNAUTHORIZED);

        }

        $meta = json_decode(base64_decode($parts[0]), true);
        if ($meta['validTill'] - $meta['issuedAt'] > self::LIFE_TIME) {
            throw new NotAuthorisedException('Authorisation token expired', JsonResponse::HTTP_UNAUTHORIZED);
        }
    }
}
