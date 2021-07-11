<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker;

class AuthorFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('ja_JP');
        for ($i = 0; $i < 100; ++$i) {
            $author = new Author();
            if (random_int(0, 100) < 90) {
                $author->setFirstname($faker->firstName);
                $author->setLastname($faker->lastName);
            } else {
                $author->setPenname($faker->word);
            }
            $this->addReference('author_'.$i, $author);
            $manager->persist($author);
        }
        $manager->flush();
    }
}
