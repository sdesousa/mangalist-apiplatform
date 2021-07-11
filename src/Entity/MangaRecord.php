<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MangaRecordRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=MangaRecordRepository::class)
 * @UniqueEntity(
 *     fields={"manga", "record"},
 *     message="Série déjà possédé"
 * )
 * @ApiResource(
 *     collectionOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"manga_record_read", "id"}}
 *         },
 *         "post"
 *     },
 *     itemOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"manga_record_details_read", "id", "timestamp"}}
 *         },
 *         "put",
 *         "patch",
 *         "delete"
 *     }
 * )
 */
class MangaRecord
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\ManyToOne(targetEntity=Manga::class, inversedBy="mangaRecords")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"manga_record_read", "manga_record_details_read", "record_details_read"})
     */
    private ?Manga $manga;

    /**
     * @ORM\ManyToOne(targetEntity=Record::class, inversedBy="mangaRecords")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"manga_record_read", "manga_record_details_read"})
     */
    private ?Record $record;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"manga_record_read", "manga_record_details_read", "record_details_read"})
     * @Assert\Positive(message="Dois être strictement positif")
     */
    private ?int $possessedVolume;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"manga_record_read", "manga_record_details_read", "record_details_read"})
     */
    private ?string $comment;

    public function __construct()
    {
        $this->possessedVolume = 0;
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @Assert\Callback
     *
     * @param mixed $payload
     */
    public function validate(ExecutionContextInterface $context, $payload): void
    {
        $manga = $this->getManga();
        if (!is_null($manga) && $this->getPossessedVolume() > $manga->getTotalVolume()) {
            $context->buildViolation('Ne peut pas être supérieur au total de volumes')
                ->atPath('possessedVolume')
                ->addViolation()
            ;
        }
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

    public function getRecord(): ?Record
    {
        return $this->record;
    }

    public function setRecord(?Record $record): self
    {
        $this->record = $record;

        return $this;
    }

    public function getPossessedVolume(): ?int
    {
        return $this->possessedVolume;
    }

    public function setPossessedVolume(int $possessedVolume): self
    {
        $this->possessedVolume = $possessedVolume;

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

    public function isFinished(): bool
    {
        $manga = $this->getManga();

        return !is_null($manga) && $this->getPossessedVolume() === $manga->getTotalVolume();
    }
}
