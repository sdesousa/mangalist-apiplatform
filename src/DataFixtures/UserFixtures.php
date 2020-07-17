<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@admin.com');
        $user->setPassword('admin');
        $this->addReference('user', $user);
        $manager->persist($user);
        $manager->flush();
    }
}
