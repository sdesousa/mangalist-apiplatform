<?php

namespace App\DataFixtures;

use App\Entity\Editor;
use App\Entity\Manga;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class MangaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 400; $i++) {
            $manga = new Manga();
            $editor = $this->getReference('editor_' . random_int(0, 9));
            $manga->setTitle($faker->sentence(3));
            $totalVolume = (random_int(0, 100) < 70) ? null : random_int(1, 120);
            $manga->setTotalVolume($totalVolume);
            $manga->setYear(random_int(1950, 2020));
            if ($editor instanceof Editor) {
                $manga->setEditor($editor);
                $editorCollections = $editor->getEditorCollections();
                $editorCollection = $editorCollections[array_rand($editorCollections->toArray())];
                $manga->setEditorCollection($editorCollection);
            }
            (random_int(0, 100) < 70) ?: $manga->setAvailableVolume(random_int(0, $totalVolume ?? 120));
            (random_int(0, 100) < 80) ?: $manga->setComment($faker->sentence(8));
            $this->addReference('manga_' . $i, $manga);
            $manager->persist($manga);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [EditorFixtures::class];
    }
}
