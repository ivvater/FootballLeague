<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\League;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method League|null find($id, $lockMode = null, $lockVersion = null)
 * @method League|null findOneBy(array $criteria, array $orderBy = null)
 * @method League[]    findAll()
 * @method League[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeagueRepository extends ServiceEntityRepository
{
    /**
     * LeagueRepository constructor.
     * @param RegistryInterface $registry
     * @codeCoverageIgnore
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, League::class);
    }

    /**
     * Remove league
     *
     * @param League $league
     */
    public function remove(League $league): void
    {
        $this->getEntityManager()->remove($league);
        $this->getEntityManager()->flush();
    }
}
