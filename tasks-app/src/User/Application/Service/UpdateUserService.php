<?php

namespace App\User\Application\Service;

use App\User\Application\DTO\UpdateUserRequest;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Shared\Domain\Exception\DefaultException;

class UpdateUserService
{
    public function __construct(
            private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $hasher,
        private ValidatorInterface $validator
    ) {}

    public function execute(
        UpdateUserRequest $dto,
        int $id
    ): void
    {
        $validation = $this->validator->validate($dto);
        if(count($validation) > 0){
            $errors = array();
            foreach ($validation as $error){
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }
            throw new DefaultException($errors);
        }

        $user = $this->userRepository->findById($id);

        if(!$user){
            throw new DefaultException(['id' => 'The user does not exist']);
        }

        if(isset($dto->email) && $user->getEmail() !== $dto->email){
            if($this->userRepository->checkingEmailAvailability($dto->email, $user->getId())){
                throw new DefaultException(['email' => 'The user with this email already exists']);
            }else{
                if(isset($dto->email)){
                    $user->setEmail($dto->email);
                }
            }
        }

        if($dto->phone){
            $user->setPhone($dto->phone);
        }

        if($dto->name){
            $user->setName($dto->name);
        }

        if($dto->role){
            $user->setRole($dto->role);
        }

        if($dto->password){
            $user->setPassword($this->hasher->hashPassword($user, $dto->password));
        }

        $this->userRepository->save($user);
    }
}