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

class UpdateTeamValidator implements RequestValidatorInterface
{
    private $leagueService;

    /**
     * UpdateTeamValidator constructor.
     * @param LeagueService $leagueService
     * @codeCoverageIgnore
     */
    public function __construct(LeagueService $leagueService)
    {
        $this->leagueService = $leagueService;
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
