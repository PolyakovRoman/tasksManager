<?php

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function findAll(): array;

    public function findAllPaginator(int $limit, int $offset): Paginator;

    public function getUsersListQuery(): Query;

    public function checkingEmailAvailability(string $email, int $userId): array;

    public function save(User $user): void;
}