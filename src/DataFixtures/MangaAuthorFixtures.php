<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\AuthorRole;
use App\Entity\Manga;
use App\Entity\MangaAuthor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MangaAuthorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 400; ++$i) {
            $manga = $this->getReference('manga_'.$i);
            $nbAuthors = random_int(0, 100) < 80 ? 1 : random_int(2, 3);
            if ($manga instanceof Manga) {
                for ($j = 0; $j < $nbAuthors; ++$j) {
                    $author = $this->getReference('author_'.random_int(0, 99));
                    $authorRole = $this->getReference('authorRole_'.random_int(0, 3));
                    $mangaAuthor = new MangaAuthor();
                    $mangaAuthor->setManga($manga);
                    if ($author instanceof Author) {
                        $mangaAuthor->setAuthor($author);
                    }
                    if ($authorRole instanceof AuthorRole) {
                        $mangaAuthor->setAuthorRole($authorRole);
                    }
                    $manager->persist($mangaAuthor);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixtures::class,
            AuthorRoleFixtures::class,
            MangaFixtures::class,
        ];
    }
}
