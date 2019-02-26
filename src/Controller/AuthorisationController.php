<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\JwtAuthenticationService;
use App\Service\UserService;
use App\Request\Validator\User\GenerateJwtTokenValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorisationController extends AbstractController
{
    private $userService;

    private $authorisationService;

    /**
     * AuthorisationController constructor.
     * @param UserService $userService
     * @param JwtAuthenticationService $authorisationService
     * @codeCoverageIgnore
     */
    public function __construct(UserService $userService, JwtAuthenticationService $authorisationService)
    {
        $this->userService = $userService;
        $this->authorisationService = $authorisationService;
    }

    /**
     * Authorise user
     *
     * @Route("/authorisation", methods={"POST"})
     * @param Request $request
     * @param GenerateJwtTokenValidator $validator
     * @return JsonResponse
     */
    public function generateJwtToken(Request $request, GenerateJwtTokenValidator $validator)
    {
        $validator->validate($request);

        $data = json_decode(
            $request->getContent(),
            true
        );

        $user = $this->userService->getUserByEmail($data['email']);

        $jwt = $this->authorisationService->generateToken($user);

        return $this->json(['token' => $jwt], JsonResponse::HTTP_OK);
    }
}
