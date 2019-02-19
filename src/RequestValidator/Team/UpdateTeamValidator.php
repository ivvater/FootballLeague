<?php

namespace App\RequestValidator\Team;

use App\Exception\ValidationException;
use App\RequestValidator\RequestValidatorInterface;
use App\Service\LeagueService;
use App\Service\TeamService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateTeamValidator implements RequestValidatorInterface
{
    private $em;

    private $leagueService;

    private $teamService;

    public function __construct(EntityManagerInterface $em, LeagueService $leagueService, TeamService $teamService)
    {
        $this->em = $em;
        $this->leagueService = $leagueService;
        $this->teamService = $teamService;
    }

    /**
     * Validate updateTeam request
     *
     * @param Request $request
     */
    public function validate(Request $request): void
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (empty($data)) {
            throw new ValidationException('One of fields is empty', JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!empty($data['league_id']) && !$this->leagueService->isExists($data['league_id'])) {
            throw new ValidationException('League does not exists', JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
