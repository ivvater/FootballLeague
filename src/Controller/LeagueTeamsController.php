<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\League;
use App\Service\TeamService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LeagueTeamsController extends AbstractController implements JwtAuthenticationInterface
{
    private $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * Get all Teams attached to a given League
     *
     * @Route("/leagues/{id}/teams")
     * @Method("GET")
     * @param League $league
     * @return JsonResponse
     */
    public function getTeams(League $league): JsonResponse
    {
        $teams = $league->getTeams();

        return $this->json($this->teamService->toArray($teams), JsonResponse::HTTP_OK);
    }
}
