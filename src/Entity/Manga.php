<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MangaRepository")
 * @UniqueEntity(
 *     fields={"title"},
 *     message="Titre déjà présent"
 * )
 */
class Manga
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Titre obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Titre trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private string $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive(message="Dois être strictement positif")
     */
    private ?int $totalVolume;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\PositiveOrZero(message="Dois être positif")
     */
    private ?int $availableVolume;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(
     *     value="1900",
     *     message="Année invalide"
     * )
     */
    private ?int $year;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Editor", inversedBy="mangas")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Editor $editor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EditorCollection", inversedBy="mangas")
     */
    private ?EditorCollection $editorCollection;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MangaAuthor", mappedBy="manga", cascade={"persist"})
     * @var ArrayCollection<int, MangaAuthor>
     */
    private ArrayCollection $mangaAuthors;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $comment;

    /**
     * @ORM\OneToMany(targetEntity=MangaRecord::class, mappedBy="manga", orphanRemoval=true)
     * @var ArrayCollection<int, MangaRecord>
     */
    private ArrayCollection $mangaRecords;

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
     * @return ArrayCollection<int, MangaAuthor>
     */
    public function getMangaAuthors(): ArrayCollection
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
     * @return ArrayCollection<int, MangaRecord>
     */
    public function getMangaRecords(): ArrayCollection
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
