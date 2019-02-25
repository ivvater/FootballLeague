<?php

declare(strict_types=1);

namespace App\Response\Transformer;

use App\Entity\Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{
    /**
     * General rule for Team transformation in API responses.
     * This rule will be recursively applied to all Team objects if the Collection will be transformed
     *
     * @param Team $team
     * @return array
     */
    public function transform(Team $team): array
    {
        return [
            'id' => $team->getId(),
            'name' => $team->getName(),
            'strip' => $team->getStrip(),
            'league' => $team->getLeague()->getId(),
        ];
    }
}
