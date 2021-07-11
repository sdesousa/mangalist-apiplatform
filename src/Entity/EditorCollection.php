<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EditorCollectionRepository")
 * @ApiResource(
 *     collectionOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"editor_collection_read", "id"}},
 *             "skip_null_values": false
 *         },
 *         "post"
 *     },
 *     itemOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"editor_collection_details_read", "id", "timestamp"}},
 *             "skip_null_values": false
 *         },
 *         "put",
 *         "patch",
 *         "delete"
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "ipartial",
 *     }
 * )
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={
 *         "id": "ASC",
 *         "name": {
 *             "default_direction": "ASC",
 *             "nulls_comparison": OrderFilter::NULLS_LARGEST
 *         },
 *     }
 * )
 */
class EditorCollection
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *     "editor_collection_read",
     *     "editor_collection_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "manga_details_read",
     *     "editor_details_read",
     *     "author_details_read"
     * })
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Titre trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Editor", inversedBy="editorCollections")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"editor_collection_read", "editor_collection_details_read"})
     */
    private ?Editor $editor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manga", mappedBy="editorCollection")
     * @Groups({"editor_collection_read", "editor_collection_details_read"})
     *
     * @var Collection<int, Manga>
     */
    private Collection $mangas;

    public function __construct()
    {
        $this->mangas = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Manga>
     */
    public function getMangas(): Collection
    {
        return $this->mangas;
    }

    public function addManga(Manga $manga): self
    {
        if (!$this->mangas->contains($manga)) {
            $this->mangas[] = $manga;
            $manga->setEditorCollection($this);
        }

        return $this;
    }

    public function removeManga(Manga $manga): self
    {
        if ($this->mangas->contains($manga)) {
            $this->mangas->removeElement($manga);
            // set the owning side to null (unless already changed)
            if ($manga->getEditorCollection() === $this) {
                $manga->setEditorCollection(null);
            }
        }

        return $this;
    }
}
