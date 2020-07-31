<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RecordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RecordRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"id"}}
 *          },
 *          "post"
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"record_details_read", "id", "timestamp"}}
 *          },
 *          "put",
 *          "patch",
 *          "delete"
 *     }
 * )
 */
class Record
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\OneToMany(targetEntity=MangaRecord::class, mappedBy="record", orphanRemoval=true)
     * @Groups({"record_details_read"})
     * @var Collection<int, MangaRecord>
     */
    private Collection $mangaRecords;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="record", cascade={"persist", "remove"})
     * @Groups({"record_details_read"})
     * @var User
     */
    private User $user;

    public function __construct()
    {
        $this->mangaRecords = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
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
            $mangaRecord->setRecord($this);
        }

        return $this;
    }

    public function removeMangaRecord(MangaRecord $mangaRecord): self
    {
        if ($this->mangaRecords->contains($mangaRecord)) {
            $this->mangaRecords->removeElement($mangaRecord);
            // set the owning side to null (unless already changed)
            if ($mangaRecord->getRecord() === $this) {
                $mangaRecord->setRecord(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
