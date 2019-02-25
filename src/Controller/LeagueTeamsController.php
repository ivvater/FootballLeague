<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\League;
use App\Response\Factory\ResponseFactory;
use App\Service\TeamService;
use App\Response\Transformer\TeamTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LeagueTeamsController extends AbstractController implements JwtAuthenticationInterface
{
    private $teamService;

    private $responseFactory;

    public function __construct(TeamService $teamService, ResponseFactory $responseFactory)
    {
        $this->teamService = $teamService;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Get all Teams attached to a given League
     *
     * @Route("/leagues/{id}/teams", methods={"GET"})
     * @param League $league
     * @return JsonResponse
     */
    public function getTeams(League $league): JsonResponse
    {
        $teams = $league->getTeams();

        $response = $this->responseFactory->make($teams, new TeamTransformer);

        return $this->json($response->toArray(), JsonResponse::HTTP_OK);
    }
}
