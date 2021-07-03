<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MangaRepository")
 * @UniqueEntity(
 *     fields={"title"},
 *     message="Titre déjà présent"
 * )
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"manga_read", "id"}}
 *          },
 *          "post"
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"manga_details_read", "id", "timestamp"}}
 *          },
 *          "put",
 *          "patch",
 *          "delete"
 *     }
 * )
 */
class Manga
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *     "manga_read",
     *     "manga_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "editor_collection_details_read",
     *     "editor_details_read",
     *     "author_details_read"
     * })
     * @Assert\NotBlank(message="Titre obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Titre trop long, il doit être au plus {{ limit }} caractères"
     * )
     * @var string
     */
    private string $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({
     *     "manga_read",
     *     "manga_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "editor_collection_details_read",
     *     "editor_details_read",
     *     "author_details_read"
     * })
     * @Assert\Positive(message="Dois être strictement positif")
     * @var int|null
     */
    private ?int $totalVolume;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({
     *     "manga_read",
     *     "manga_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "editor_collection_details_read",
     *     "editor_details_read",
     *     "author_details_read"
     * })
     * @Assert\PositiveOrZero(message="Dois être positif")
     * @var int|null
     */
    private ?int $availableVolume;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({
     *     "manga_read",
     *     "manga_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "editor_collection_details_read",
     *     "editor_details_read",
     *     "author_details_read"
     * })
     * @Assert\GreaterThanOrEqual(
     *     value="1900",
     *     message="Année invalide"
     * )
     * @var int|null
     */
    private ?int $year;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Editor", inversedBy="mangas")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({
     *     "manga_read",
     *     "manga_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "editor_collection_details_read",
     *     "author_details_read"
     * })
     * @var Editor|null
     */
    private ?Editor $editor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EditorCollection", inversedBy="mangas")
     * @Groups({
     *     "manga_read",
     *     "manga_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "editor_details_read",
     *     "author_details_read"
     * })
     * @var EditorCollection|null
     */
    private ?EditorCollection $editorCollection;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MangaAuthor", mappedBy="manga", cascade={"persist"})
     * @Groups({
     *     "manga_read",
     *     "manga_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "editor_collection_details_read",
     *     "editor_details_read"
     * })
     * @var Collection<int, MangaAuthor>
     */
    private Collection $mangaAuthors;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({
     *     "manga_read",
     *     "manga_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "editor_collection_details_read",
     *     "editor_details_read",
     *     "author_details_read"
     * })
     * @var string|null
     */
    private ?string $comment;

    /**
     * @ORM\OneToMany(targetEntity=MangaRecord::class, mappedBy="manga", orphanRemoval=true)
     * @Groups({"manga_read", "manga_details_read"})
     * @var Collection<int, MangaRecord>
     */
    private Collection $mangaRecords;

    public function __construct()
    {
        $this->mangaAuthors = new ArrayCollection();
        $this->mangaRecords = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTotalVolume(): ?int
    {
        return $this->totalVolume;
    }

    public function setTotalVolume(?int $totalVolume): self
    {
        $this->totalVolume = $totalVolume;

        return $this;
    }

    public function getAvailableVolume(): ?int
    {
        return $this->availableVolume;
    }

    public function setAvailableVolume(?int $availableVolume): self
    {
        $this->availableVolume = $availableVolume;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getEditorCollection(): ?EditorCollection
    {
        return $this->editorCollection;
    }

    public function setEditorCollection(?EditorCollection $editorCollection): self
    {
        $this->editorCollection = $editorCollection;

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
            $mangaAuthor->setManga($this);
        }

        return $this;
    }

    public function removeMangaAuthor(MangaAuthor $mangaAuthor): self
    {
        if ($this->mangaAuthors->contains($mangaAuthor)) {
            $this->mangaAuthors->removeElement($mangaAuthor);
            // set the owning side to null (unless already changed)
            if ($mangaAuthor->getManga() === $this) {
                $mangaAuthor->setManga(null);
            }
        }

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, MangaRecord>
     */
    public function getMangaRecords(): Collection
    {
        return $this->mangaRecords;
    }

    public function addMangaRecord(MangaRecord $mangaRecord): self
    {
        if (!$this->mangaRecords->contains($mangaRecord)) {
            $this->mangaRecords[] = $mangaRecord;
            $mangaRecord->setManga($this);
        }

        return $this;
    }

    public function removeMangaRecord(MangaRecord $mangaRecord): self
    {
        if ($this->mangaRecords->contains($mangaRecord)) {
            $this->mangaRecords->removeElement($mangaRecord);
            // set the owning side to null (unless already changed)
            if ($mangaRecord->getManga() === $this) {
                $mangaRecord->setManga(null);
            }
        }

        return $this;
    }
}
