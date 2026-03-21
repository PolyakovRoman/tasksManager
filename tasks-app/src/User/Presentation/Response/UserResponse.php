<?php

namespace App\User\Presentation\Response;

use App\User\Application\DTO\UserListResponse;
use App\User\Domain\Entity\User;
use App\User\Domain\Enum\Role;

final class UserResponse
{
    public function toListItem(User $user): UserListResponse
    {
        return new UserListResponse(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getPhone(),
            $this->normalizeRole($user->getRole())
        );
    }

    private function normalizeRole(?Role $role): ?array
    {

        if ($role === null) {
            return null;
        }

        foreach (Role::cases() as $case) {
            if ($case->name === $role->name || $case->value === $role->value) {
                return [
                    'name' => $case->name,
                    'value' => $case->value,
                ];
            }
        }

        return null;
    }
}