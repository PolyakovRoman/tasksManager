<?php

namespace App\Application\UseCase;

use App\Domain\Repository\UserRepositoryInterface;

class UserExistsUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $email): bool
    {
        $user = $this->userRepository->findByEmail($email);

        return $user ? true : false;
    }
}