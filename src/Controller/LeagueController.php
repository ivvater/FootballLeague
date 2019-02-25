<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\League;
use App\Service\LeagueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LeagueController extends AbstractController implements JwtAuthenticationInterface
{
    private $leagueService;

    public function __construct(LeagueService $leagueService)
    {
        $this->leagueService = $leagueService;
    }

    /**
     * Delete League with all teams attached
     *
     * @Route("/leagues/{id}", methods={"DELETE"})
     * @param League $league
     * @return JsonResponse
     */
    public function delete(League $league): JsonResponse
    {
        $this->leagueService->delete($league);

        return $this->json([], JsonResponse::HTTP_NO_CONTENT);
    }
}
