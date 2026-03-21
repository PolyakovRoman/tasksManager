<?php

namespace App\User\Application\Service;

use App\User\Application\DTO\CreateUserRequest;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Shared\Domain\Exception\DefaultException;

class CreateUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $hasher,
        private ValidatorInterface $validator
    ) {}

    public function execute(CreateUserRequest $dto): void
    {
        $validation = $this->validator->validate($dto);
        if(count($validation) > 0){
            $errors = array();
            foreach ($validation as $error){
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }
            throw new DefaultException($errors);
        }

        $user = $this->userRepository->findByEmail($dto->email);

        if($user){
            throw new DefaultException(['email' => 'The user with this email already exists']);
        }

        $user = new User();
        $user->setEmail($dto->email);
        $user->setPhone($dto->phone);
        $user->setName($dto->name);
        $user->setRole($dto->role);
        $user->setPassword($this->hasher->hashPassword($user, $dto->password));

        $this->userRepository->save($user);
    }
}