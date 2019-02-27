<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository implements TeamRepositoryInterface
{
    /**
     * TeamRepository constructor.
     * @param RegistryInterface $registry
     * @codeCoverageIgnore
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**
     * Save Team
     *
     * @param Team $team
     * @return Team
     */
    public function save(Team $team): Team
    {
        $this->getEntityManager()->persist($team);
        $this->getEntityManager()->flush();

        return $team;
    }
}
