<?php
namespace App\Domain\Repository;

use \App\Domain\Entity\Task;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface TaskRepositoryInterface
{
    public function findAllPaginator(int $limit, int $offset): Paginator;

    public function findById(int $id): ?Task;
}