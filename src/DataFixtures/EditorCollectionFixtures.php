<?php

namespace App\DataFixtures;

use App\Entity\Editor;
use App\Entity\EditorCollection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker;

class EditorCollectionFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $editor = $this->getReference('editor_' . $i);
            $nbCollection = random_int(2, 5);
            for ($j = 0; $j < $nbCollection; $j++) {
                $editorCollection = new EditorCollection();
                $editorCollection->setName($faker->word);
                if ($editor instanceof Editor) {
                    $editorCollection->setEditor($editor);
                }
                $manager->persist($editorCollection);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [EditorFixtures::class];
    }
}
