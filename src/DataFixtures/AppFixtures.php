<?php

namespace App\DataFixtures;

use App\Entity\League;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('test.user@test.com');
        $user->setPassword(password_hash('test123', PASSWORD_DEFAULT));
        $manager->persist($user);

        $league = new League();
        $league->setId(1);
        $league->setName('testLeague');
        $manager->persist($league);

        $team = new Team();
        $team->setName('testTeam');
        $team->setStrip('testStrip');
        $team->setLeague($league);
        $manager->persist($team);

        $manager->flush();
    }
}
