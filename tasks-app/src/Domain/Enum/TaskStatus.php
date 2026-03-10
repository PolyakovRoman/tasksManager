<?php
namespace App\Domain\Enum;

enum TaskStatus: string
{
    case OPEN = 'Открыта';
    case WORK = 'В работе';
    case CLOSE = 'Закрыта';

    public function isOpen(): bool
    {
        return $this === self::OPEN;
    }

    public function isWork(): bool
    {
        return $this === self::WORK;
    }

    public function isClose(): bool
    {
        return $this === self::CLOSE;
    }
}