<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Team;
use App\Factory\TeamFactory;
use App\Repository\TeamRepositoryInterface;

class TeamService
{
    private $teamFactory;

    private $teamRepository;

    private $leagueService;

    /**
     * TeamService constructor.
     * @param TeamFactory $teamFactory
     * @param TeamRepositoryInterface $teamRepository
     * @param LeagueService $leagueService
     * @codeCoverageIgnore
     */
    public function __construct(
        TeamFactory $teamFactory,
        TeamRepositoryInterface $teamRepository,
        LeagueService $leagueService
    )
    {
        $this->teamFactory = $teamFactory;
        $this->teamRepository = $teamRepository;
        $this->leagueService = $leagueService;
    }

    /**
     * Create Team from array
     *
     * @param array $data
     * @return Team
     */
    public function create(array $data): Team
    {
        $league = $this->leagueService->find($data['league_id']);
        $team = $this->teamRepository->save($this->teamFactory->make($data, $league));

        return $team;
    }

    /**
     * Update existing Team from array
     *
     * @param Team $team
     * @param array $data
     * @return Team
     */
    public function update(Team $team, array $data): Team
    {
        if (!empty($data['name'])) {
            $team->setName($data['name']);
        }

        if (!empty($data['strip'])) {
            $team->setStrip($data['strip']);
        }

        if (!empty($data['league_id'])) {
            $league = $this->leagueService->find($data['league_id']);
            $team->setLeague($league);
        }

        return $this->teamRepository->save($team);
    }

    /**
     * Get one Team by Team name or null if no team found
     *
     * @param string $name
     * @return Team|null
     */
    public function getOneByName(string $name): ?Team
    {
        return $this->teamRepository->findOneByName($name);
    }
}
