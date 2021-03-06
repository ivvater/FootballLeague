<?php

declare(strict_types=1);

namespace App\Request\Validator\Team;

use App\Exception\ValidationException;
use App\Request\Validator\RequestValidatorInterface;
use App\Service\LeagueService;
use App\Service\TeamService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateTeamValidator implements RequestValidatorInterface
{
    private $leagueService;

    private $teamService;

    /**
     * CreateTeamValidator constructor.
     * @param LeagueService $leagueService
     * @param TeamService $teamService
     * @codeCoverageIgnore
     */
    public function __construct(LeagueService $leagueService, TeamService $teamService)
    {
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

        if (empty($data['league_id']) || empty($data['name']) || empty($data['strip'])) {
            throw new ValidationException('One of fields is empty', JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$this->leagueService->isExists($data['league_id'])) {
            throw new ValidationException('League does not exists', JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->teamService->getOneByName($data['name'])) {
            throw new ValidationException(
                'Team with a given name already exists',
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
