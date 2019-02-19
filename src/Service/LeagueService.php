<?php

namespace App\Service;

use App\Entity\League;
use Doctrine\ORM\EntityManagerInterface;

class LeagueService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function isExists(int $leagueId) :bool
    {
        return $this->em->getRepository('App:League')->find($leagueId) !== null;
    }

    /**
     * Delete given League
     *
     * @param League $league
     */
    public function delete(League $league): void
    {
        $this->em->remove($league);
        $this->em->flush();
    }
}
