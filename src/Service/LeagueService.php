<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\League;
use App\Repository\LeagueRepositoryInterface;

class LeagueService
{
    private $leagueRepository;

    /**
     * LeagueService constructor.
     * @param LeagueRepositoryInterface $leagueRepository
     * @codeCoverageIgnore
     */
    public function __construct(LeagueRepositoryInterface $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * Check if given league exists
     *
     * @param int $leagueId
     * @return bool
     */
    public function isExists(int $leagueId): bool
    {
        return $this->leagueRepository->find($leagueId) !== null;
    }

    /**
     * @param int $leagueId
     * @return League
     */
    public function find(int $leagueId): League
    {
        return $this->leagueRepository->find($leagueId);
    }

    /**
     * Delete given League
     *
     * @param League $league
     */
    public function delete(League $league): void
    {
        $this->leagueRepository->remove($league);
    }
}
