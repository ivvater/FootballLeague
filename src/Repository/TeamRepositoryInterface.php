<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use App\Entity\Team;

interface TeamRepositoryInterface extends ObjectRepository
{
    public function save(Team $team): Team;
}
