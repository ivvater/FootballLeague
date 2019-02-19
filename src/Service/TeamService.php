<?php

namespace App\Service;

use App\Entity\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeamService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Create Team from array
     *
     * @param array $data
     * @return Team
     */
    public function create(array $data): Team
    {
        $team = new Team();
        $team->setName($data['name']);
        $team->setStrip($data['strip']);

        $league = $this->em->getRepository('App:League')->find($data['league_id']);
        $team->setLeague($league);

        $this->em->persist($team);
        $this->em->flush();

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

        if (!empty($data['league_id']) && $team->getLeague()->getId() != $data['league_id']) {
            $league = $this->em->getRepository('App:League')->find($data['league_id']);
            $team->setLeague($league);
        }

        $this->em->persist($team);
        $this->em->flush();

        return $team;
    }

    /**
     * Get one Team by Team name or null if no team found
     *
     * @param String $name
     * @return Team|null
     */
    public function getOneByName(String $name): ?Team
    {
        return $this->em->getRepository('App:Team')->findOneByName($name);
    }

    /**
     * Simple and fast solution to transform Team or collection of a Team into array
     *
     * @param Team|ArrayCollection $teams
     * @return array
     */
    public function toArray($teams): array
    {
        $return = [];

        if (is_iterable($teams)) {
            foreach ($teams as $team) {
                $return[] = $this->transformModel($team);
            }
        } elseif ($teams instanceof Team) {
            $return = $this->transformModel($teams);
        } else {
            throw new InvalidArgumentException(
                'Can not transform Team to array',
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $return;
    }

    /**
     * Transform Team model to an array
     *
     * @param Team $team
     * @return array
     */
    protected function transformModel(Team $team): array
    {
        return [
            'id' => $team->getId(),
            'name' => $team->getName(),
            'strip' => $team->getStrip(),
            'league_id' => $team->getLeague()->getId(),
        ];
    }
}
