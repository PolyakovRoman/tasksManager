<?php
namespace App\Domain\Repository;

use \App\Domain\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function findAll(): array;

    public function findPaginator(int $limit, int $offset): Paginator;

    public function save(User $user): void;
}