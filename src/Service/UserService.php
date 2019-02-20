<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get one user by given email or null if no User found
     *
     * @param String $email
     * @return User|null
     */
    public function getUserByEmail(String $email): ?User
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }
}
