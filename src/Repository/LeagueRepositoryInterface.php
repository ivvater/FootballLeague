<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use App\Entity\League;

interface LeagueRepositoryInterface extends ObjectRepository
{
    public function remove(League $league): void;
}
