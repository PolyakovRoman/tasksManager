<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Task;
use App\Domain\Repository\TaskRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param int $id
     * @return Task|null
     */
    public function findById(int $id): ?Task
    {
        return $this->find($id);
    }

    public function findAllPaginator(int $limit, int $offset): Paginator
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        return new Paginator($query);
    }
}
