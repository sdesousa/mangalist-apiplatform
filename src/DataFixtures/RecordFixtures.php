<?php

namespace App\DataFixtures;

use App\Entity\Record;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RecordFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $record = new Record();
        $user = $this->getReference('user');
        if ($user instanceof User) {
            $record->setUser($user);
        }
        $this->addReference('record', $record);
        $manager->persist($record);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
