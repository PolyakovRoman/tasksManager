<?php

namespace App\User\Presentation\Request;

use App\User\Application\DTO\CreateUserRequest;
use App\User\Application\DTO\UpdateUserRequest;
use App\User\Domain\Enum\Role;
use App\Shared\Domain\Traits\ApiRequestTrait;
use Symfony\Component\HttpFoundation\Request;

final class UserRequest
{
    use ApiRequestTrait;

    public function create(Request $request): CreateUserRequest
    {
        $data = $this->decodeJson($request);

        return new CreateUserRequest(
            (string)($data['email'] ?? ''),
            (string)($data['password'] ?? ''),
            (string)($data['name'] ?? ''),
            isset($data['phone']) ? (string)$data['phone'] : null,
            $this->mapRole($data['role'] ?? null)
        );
    }

    public function registration(Request $request): CreateUserRequest
    {
        $data = $this->decodeJson($request);

        return new CreateUserRequest(
            (string)($data['email'] ?? ''),
            (string)($data['password'] ?? ''),
            (string)($data['name'] ?? ''),
            isset($data['phone']) ? (string)$data['phone'] : null,
            Role::ROLE_USER
        );
    }

    public function update(Request $request): UpdateUserRequest
    {
        $data = $this->decodeJson($request);

        return new UpdateUserRequest(
            isset($data['email']) ? (string)$data['email'] : null,
            isset($data['password']) ? (string)$data['password'] : null,
            isset($data['name']) ? (string)$data['name'] : null,
            isset($data['phone']) ? (string)$data['phone'] : null,
            $this->mapRole($data['role'] ?? null)
        );
    }

    private function mapRole(mixed $rawRole): ?Role
    {
        if ($rawRole === null || $rawRole === '') {
            return null;
        }

        foreach (Role::cases() as $case) {
            if ($case->name === $rawRole || $case->value === $rawRole) {
                return $case;
            }
        }

        return null;
    }
}