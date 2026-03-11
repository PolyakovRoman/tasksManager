<?php

namespace App\DataFixtures;

use App\Domain\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Domain\Enum\RoleLevel;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ){}

    public function load(ObjectManager $manager): void
    {
        //Admin
        $user = new User();
        $user->setName('Admin');
        $user->setEmail('developer@mail.ru');
        $user->setPhone('79132222222');
        $user->setRole(RoleLevel::ROLE_ADMIN);
        $user->setPassword($this->hasher->hashPassword($user, 'test'));
        $manager->persist($user);

        //User
        $user = new User();
        $user->setName('User');
        $user->setEmail('user@mail.ru');
        $user->setPhone('79133333333');
        $user->setRole(RoleLevel::ROLE_USER);
        $user->setPassword($this->hasher->hashPassword($user, 'test'));
        $manager->persist($user);

        $manager->flush();
    }
}
