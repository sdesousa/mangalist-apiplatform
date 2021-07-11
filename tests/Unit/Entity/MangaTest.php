<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Editor;
use App\Entity\EditorCollection;
use App\Entity\Manga;
use App\Entity\MangaAuthor;
use App\Entity\MangaRecord;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class MangaTest extends TestCase
{
    private Manga $manga;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->manga = new Manga();
    }

    public function testGetTitle(): void
    {
        $value = 'Dragon ball';
        $response = $this->manga->setTitle($value);

        self::assertInstanceOf(Manga::class, $response);
        self::assertEquals($value, $this->manga->getTitle());
    }

    public function testGetTotalVolume(): void
    {
        $value = 42;
        $response = $this->manga->setTotalVolume($value);

        self::assertInstanceOf(Manga::class, $response);
        self::assertEquals($value, $this->manga->getTotalVolume());
    }

    public function testGetAvailableVolume(): void
    {
        $value = 42;
        $response = $this->manga->setAvailableVolume($value);

        self::assertInstanceOf(Manga::class, $response);
        self::assertEquals($value, $this->manga->getAvailableVolume());
    }

    public function testGetYear(): void
    {
        $value = 1984;
        $response = $this->manga->setYear($value);

        self::assertInstanceOf(Manga::class, $response);
        self::assertEquals($value, $this->manga->getYear());
    }

    public function testGetEditor(): void
    {
        $value = new Editor();
        $response = $this->manga->setEditor($value);

        self::assertInstanceOf(Manga::class, $response);
        self::assertEquals($value, $this->manga->getEditor());
    }

    public function testGetEditorCollection(): void
    {
        $value = new EditorCollection();
        $response = $this->manga->setEditorCollection($value);

        self::assertInstanceOf(Manga::class, $response);
        self::assertEquals($value, $this->manga->getEditorCollection());
    }

    public function testGetComment(): void
    {
        $value = 'Lorem ipsum';
        $response = $this->manga->setComment($value);

        self::assertInstanceOf(Manga::class, $response);
        self::assertEquals($value, $this->manga->getComment());
    }

    public function testGetMangaAuthors(): void
    {
        $mangaAuthor1 = new MangaAuthor();
        $mangaAuthor2 = new MangaAuthor();
        $mangaAuthor3 = new MangaAuthor();

        $this->manga->addMangaAuthor($mangaAuthor1);
        $this->manga->addMangaAuthor($mangaAuthor2);
        $this->manga->addMangaAuthor($mangaAuthor3);

        self::assertCount(3, $this->manga->getMangaAuthors());
        self::assertTrue($this->manga->getMangaAuthors()->contains($mangaAuthor1));
        self::assertTrue($this->manga->getMangaAuthors()->contains($mangaAuthor2));
        self::assertTrue($this->manga->getMangaAuthors()->contains($mangaAuthor3));

        $response = $this->manga->removeMangaAuthor($mangaAuthor3);

        self::assertInstanceOf(Manga::class, $response);
        self::assertCount(2, $this->manga->getMangaAuthors());
        self::assertTrue($this->manga->getMangaAuthors()->contains($mangaAuthor1));
        self::assertTrue($this->manga->getMangaAuthors()->contains($mangaAuthor2));
        self::assertFalse($this->manga->getMangaAuthors()->contains($mangaAuthor3));
    }

    public function testGetMangaRecords(): void
    {
        $mangaRecord1 = new MangaRecord();
        $mangaRecord2 = new MangaRecord();
        $mangaRecord3 = new MangaRecord();

        $this->manga->addMangaRecord($mangaRecord1);
        $this->manga->addMangaRecord($mangaRecord2);
        $this->manga->addMangaRecord($mangaRecord3);

        self::assertCount(3, $this->manga->getMangaRecords());
        self::assertTrue($this->manga->getMangaRecords()->contains($mangaRecord1));
        self::assertTrue($this->manga->getMangaRecords()->contains($mangaRecord2));
        self::assertTrue($this->manga->getMangaRecords()->contains($mangaRecord3));

        $response = $this->manga->removeMangaRecord($mangaRecord3);

        self::assertInstanceOf(Manga::class, $response);
        self::assertCount(2, $this->manga->getMangaRecords());
        self::assertTrue($this->manga->getMangaRecords()->contains($mangaRecord1));
        self::assertTrue($this->manga->getMangaRecords()->contains($mangaRecord2));
        self::assertFalse($this->manga->getMangaRecords()->contains($mangaRecord3));
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTime();
        $response = $this->manga->setUpdatedAt($updatedAt);

        self::assertInstanceOf(Manga::class, $response);
        self::assertEquals($updatedAt, $this->manga->getUpdatedAt());
    }
}
