<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Task;
use App\Domain\Repository\TaskRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TaskRepository implements TaskRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(Task::class);
    }

    /**
     * @param int $id
     * @return Task|null
     */
    public function findById(int $id): ?Task
    {
        return $this->repository->find($id);
    }

    public function findAllPaginator(int $limit, int $offset): Paginator
    {
        $query = $this->repository
            ->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        return new Paginator($query);
    }
}
