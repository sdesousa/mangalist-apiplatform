<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 * @ApiResource(collectionOperations={
 *     "get": {
 *         "normalization_context": {"groups": {"author_read", "id"}}
 *     },
 *     "post"
 * },
 * itemOperations={
 *     "get": {
 *         "normalization_context": {"groups": {"author_details_read", "id", "timestamp"}}
 *     },
 *     "put",
 *     "patch",
 *     "delete"
 * })
 */
class Author
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *     "author_read",
     *     "author_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "manga_details_read",
     *     "editor_details_read",
     *     "author_role_details_read"
     * })
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Prénom trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private ?string $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *     "author_read",
     *     "author_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "manga_details_read",
     *     "editor_details_read",
     *     "author_role_details_read"
     * })
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Nom trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private ?string $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *     "author_read",
     *     "author_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "manga_details_read",
     *     "editor_details_read",
     *     "author_role_details_read"
     * })
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Pseudo trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private ?string $penname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MangaAuthor", mappedBy="author")
     * @Groups({"author_read", "author_details_read"})
     *
     * @var Collection<int, MangaAuthor>
     */
    private Collection $mangaAuthors;

    public function __construct()
    {
        $this->mangaAuthors = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPenname(): ?string
    {
        return $this->penname;
    }

    public function setPenname(?string $penname): self
    {
        $this->penname = $penname;

        return $this;
    }

    /**
     * @return Collection<int, MangaAuthor>
     */
    public function getMangaAuthors(): Collection
    {
        return $this->mangaAuthors;
    }

    public function addMangaAuthor(MangaAuthor $mangaAuthor): self
    {
        if (!$this->mangaAuthors->contains($mangaAuthor)) {
            $this->mangaAuthors[] = $mangaAuthor;
            $mangaAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeMangaAuthor(MangaAuthor $mangaAuthor): self
    {
        if ($this->mangaAuthors->contains($mangaAuthor)) {
            $this->mangaAuthors->removeElement($mangaAuthor);
            // set the owning side to null (unless already changed)
            if ($mangaAuthor->getAuthor() === $this) {
                $mangaAuthor->setAuthor(null);
            }
        }

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->getPenname() ?? $this->getLastname().' '.$this->getFirstname();
    }
}
