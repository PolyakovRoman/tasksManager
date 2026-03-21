<?php

namespace App\User\Application\DTO;

use App\User\Domain\Enum\Role;
use Symfony\Component\Validator\Constraints as Validator;

final class UpdateUserRequest
{
    #[Validator\Email]
    public ?string $email;

    #[Validator\Length(min: 6)]
    public ?string $password;

    #[Validator\Length(min: 2, max: 50)]
    public ?string $name;

    #[Validator\Regex(
        pattern: '/^\+?\d{11}$/',
        message: 'Enter the correct Russian phone number'
    )]
    public ?string $phone;

    #[Validator\Enum(class: Role::class)]
    public ?Role $role;


    public function __construct(
        ?string $email = null,
        ?string $password = null,
        ?string $name = null,
        ?string $phone = null,
        ?Role $role = null
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->role = $role;
    }
}