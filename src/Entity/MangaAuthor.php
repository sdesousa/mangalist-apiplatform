<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MangaAuthorRepository")
 * @ApiResource(
 *     collectionOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"manga_author_read", "id"}}
 *         },
 *         "post"
 *     },
 *     itemOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"manga_author_details_read", "id", "timestamp"}}
 *         },
 *         "put",
 *         "patch",
 *         "delete"
 *     }
 * )
 */
class MangaAuthor
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AuthorRole", inversedBy="mangaAuthors")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({
     *     "manga_author_read",
     *     "manga_author_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_details_read",
     *     "editor_details_read",
     *     "author_details_read"
     * })
     */
    private ?AuthorRole $authorRole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manga", inversedBy="mangaAuthors")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({
     *     "manga_author_read",
     *     "manga_author_details_read",
     *     "author_details_read"
     * })
     */
    private ?Manga $manga;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="mangaAuthors")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({
     *     "manga_author_read",
     *     "manga_author_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_details_read",
     *     "editor_details_read",
     *     "author_role_details_read"
     * })
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
