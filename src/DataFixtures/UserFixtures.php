<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const DEFAULT_USER = [
        'email' => 'test@admin.com',
        'password' => 'admin',
    ];
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail(self::DEFAULT_USER['email']);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            self::DEFAULT_USER['password']
        ));
        $this->addReference('user', $user);
        $manager->persist($user);
        $manager->flush();
    }
}
