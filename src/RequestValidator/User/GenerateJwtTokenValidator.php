<?php

namespace App\RequestValidator\User;

use App\Exception\ValidationException;
use App\RequestValidator\RequestValidatorInterface;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GenerateJwtTokenValidator implements RequestValidatorInterface
{
    private $em;

    private $userService;

    public function __construct(EntityManagerInterface $em, UserService $userService)
    {
        $this->em = $em;
        $this->userService = $userService;
    }

    /**
     * Validate generateJwtToken request
     *
     * @param Request $request
     */
    public function validate(Request $request): void
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (empty($data['email']) || empty($data['password'])) {
            throw new ValidationException('Invalid credentials', JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->userService->getUserByEmail($data['email']);
        if ($user === null || !password_verify($data['password'], $user->getPassword())) {
            throw new ValidationException('Invalid credentials', JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
