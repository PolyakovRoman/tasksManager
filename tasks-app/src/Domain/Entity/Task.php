<?php

namespace App\Domain\Entity;

use App\Infrastructure\Doctrine\Repository\TaskRepository;
use Symfony\Component\Uid\Uuid;
use App\Domain\Enum\TaskStatus;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table(name: '`task`')]
#[ORM\Index(columns: ["status"])]
#[ORM\Index(columns: ["user_completed_id"])]
class Task
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private Uiid $id;

    #[ORM\Column(length: 255)]
    private ?string $name;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $userAppointed;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $userCompleted;

    #[ORM\Column(type: "string", enumType: TaskStatus::class)]
    private TaskStatus $status;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $deadline;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getUserAppointed(): User
    {
        return $this->userAppointed;
    }

    public function getUserCompleted(): ?User
    {
        return $this->userCompleted;
    }

    public function setUserCompleted(?User $userCompleted): void
    {
        $this->userCompleted = $userCompleted;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function close(): void
    {
        $this->status = TaskStatus::CLOSED;
    }

    public function work(): void
    {
        $this->status = TaskStatus::WORK;
    }

    public function open(): void
    {
        $this->status = TaskStatus::OPEN;
    }

    public function getDeadline(): \DateTimeImmutable
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeImmutable $deadline): void
    {
        $this->deadline = $deadline;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
