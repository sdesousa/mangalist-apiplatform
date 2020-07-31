<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MangaAuthorRepository")
 * @ApiResource()
 */
class MangaAuthor
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AuthorRole", inversedBy="mangaAuthors")
     * @ORM\JoinColumn(nullable=false)
     * @var AuthorRole|null
     */
    private ?AuthorRole $authorRole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manga", inversedBy="mangaAuthors")
     * @ORM\JoinColumn(nullable=false)
     * @var Manga|null
     */
    private ?Manga $manga;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="mangaAuthors")
     * @ORM\JoinColumn(nullable=false)
     * @var Author|null
     */
    private ?Author $author;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getAuthorRole(): ?AuthorRole
    {
        return $this->authorRole;
    }

    public function setAuthorRole(?AuthorRole $authorRole): self
    {
        $this->authorRole = $authorRole;

        return $this;
    }

    public function getManga(): ?Manga
    {
        return $this->manga;
    }

    public function setManga(?Manga $manga): self
    {
        $this->manga = $manga;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }
}
