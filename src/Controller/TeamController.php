<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Team;
use App\Response\Factory\ResponseFactory;
use App\Service\LeagueService;
use App\Service\TeamService;
use App\Request\Validator\Team\CreateTeamValidator;
use App\Request\Validator\Team\UpdateTeamValidator;
use App\Response\Transformer\TeamTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class TeamController extends AbstractController implements JwtAuthenticationInterface
{
    private $leagueService;

    private $teamService;

    private $responseFactory;

    public function __construct(LeagueService $leagueService, TeamService $teamService, ResponseFactory $responseFactory)
    {
        $this->leagueService = $leagueService;
        $this->teamService = $teamService;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Create team
     *
     * @Route("/teams", methods={"POST"})
     * @param Request $request
     * @param CreateTeamValidator $validator
     * @return JsonResponse
     */
    public function create(Request $request, CreateTeamValidator $validator): JsonResponse
    {
        $validator->validate($request);

        $data = json_decode(
            $request->getContent(),
            true
        );

        $team = $this->teamService->create($data);

        $response = $this->responseFactory->make($team, new TeamTransformer);

        return $this->json($response->toArray(), JsonResponse::HTTP_CREATED);
    }

    /**
     * Update Team
     *
     * @Route("/teams/{id}", methods={"PUT"})
     * @param Team $team
     * @param Request $request
     * @param UpdateTeamValidator $validator
     * @return JsonResponse
     */
    public function update(Team $team, Request $request, UpdateTeamValidator $validator): JsonResponse
    {
        $validator->validate($request);

        $data = json_decode(
            $request->getContent(),
            true
        );

        $team = $this->teamService->update($team, $data);

        $response = $this->responseFactory->make($team, new TeamTransformer);

        return $this->json($response->toArray(), JsonResponse::HTTP_OK);
    }
}
