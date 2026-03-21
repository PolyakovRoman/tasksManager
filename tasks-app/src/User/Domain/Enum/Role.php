<?php

namespace App\User\Domain\Enum;

enum Role: string
{
    case ROLE_ADMIN = 'Admin';
    case ROLE_USER = 'User';
    case PUBLIC_ACCESS = 'All Users';

    public function isAdmin(): bool
    {
        return $this === self::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this === self::ROLE_USER;
    }

    public function isPublic(): bool
    {
        return $this === self::PUBLIC_ACCESS;
    }
}