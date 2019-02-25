<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\League;
use App\Entity\Team;

class TeamFactory
{

    /**
     * Team factory. Make a Team instance from array
     *
     * @param array $data
     * @param League $league
     * @return Team
     */
    public function make(array $data, League $league): Team
    {
        $team = new Team();
        $team->setName($data['name']);
        $team->setStrip($data['strip']);
        $team->setLeague($league);

        return $team;
    }

}