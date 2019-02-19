<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Get one user by given email or null if no User found
     *
     * @param String $email
     * @return User|null
     */
    public function getUserByEmail(String $email): ?User
    {
        return $this->em->getRepository('App:User')->findOneBy(['email' => $email]);
    }
}
