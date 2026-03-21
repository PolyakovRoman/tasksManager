<?php

namespace App\User\Application\DTO;

use App\User\Domain\Enum\Role;
use Symfony\Component\Validator\Constraints as Validator;

final class CreateUserRequest
{
    #[Validator\NotBlank]
    #[Validator\Email]
    public string $email;

    #[Validator\NotBlank]
    #[Validator\Length(min: 6)]
    public string $password;

    #[Validator\NotBlank]
    #[Validator\Length(min: 2, max: 50)]
    public string $name;

    #[Validator\Regex(
        pattern: '/^\+?\d{11}$/',
        message: 'Enter the correct Russian phone number'
    )]
    public ?string $phone = null;

    #[Validator\NotBlank]
    #[Validator\Enum(class: Role::class)]
    public Role $role;


    public function __construct(
        string $email,
        string $password,
        string $name,
        ?string $phone,
        ?Role $role
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->role = $role;
    }
}