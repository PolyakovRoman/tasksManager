<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository implements UserRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(User::class);
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return $this->repository->find($id);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return $this->repository
            ->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Paginator
     */
    public function findAllPaginator(int $limit, int $offset): Paginator
    {
        $query = $this->repository
            ->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        return new Paginator($query);
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
