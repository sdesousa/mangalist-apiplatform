<?php

namespace App\DataFixtures;

use App\Entity\Manga;
use App\Entity\MangaRecord;
use App\Entity\Record;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker;

class MangaRecordFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 300; ++$i) {
            $mangaRecord = new MangaRecord();
            $manga = $this->getReference('manga_'.random_int(0, 399));
            $record = $this->getReference('record');
            if ($record instanceof Record) {
                $mangaRecord->setRecord($record);
            }
            if ($manga instanceof Manga) {
                $mangaRecord->setManga($manga);
                $mangaRecord->setPossessedVolume(random_int(0, $manga->getTotalVolume() ?? 120));
            }
            $mangaRecord->setComment($faker->sentence(8));
            $manager->persist($mangaRecord);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RecordFixtures::class,
            MangaFixtures::class,
        ];
    }
}
