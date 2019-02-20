<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Team;
use App\Service\LeagueService;
use App\Service\TeamService;
use App\RequestValidator\Team\CreateTeamValidator;
use App\RequestValidator\Team\UpdateTeamValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TeamController extends AbstractController implements JwtAuthenticationInterface
{
    private $leagueService;

    private $teamService;

    public function __construct(LeagueService $leagueService, TeamService $teamService)
    {
        $this->leagueService = $leagueService;
        $this->teamService = $teamService;
    }

    /**
     * Create team
     *
     * @Route("/teams")
     * @Method("POST")
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

        return $this->json($this->teamService->toArray($team), JsonResponse::HTTP_CREATED);
    }

    /**
     * Update Team
     *
     * @Route("/teams/{id}")
     * @Method("PUT")
     * @param Team $team
     * @param Request $request
     * @param UpdateTeamValidator $validator
     * @return JsonResponse
     */
    public function update(Team $team, Request $request, UpdateTeamValidator $validator): JsonResponse
    {
        $validator->validate($request);

        $body = $request->getContent();
        $data = json_decode($body, true);

        $team = $this->teamService->update($team, $data);

        return $this->json($this->teamService->toArray($team), JsonResponse::HTTP_OK);
    }
}
