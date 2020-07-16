<?php

namespace App\Entity;

use App\Repository\RecordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecordRepository::class)
 */
class Record
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity=MangaRecord::class, mappedBy="record", orphanRemoval=true)
     * @var ArrayCollection<int, MangaRecord>
     */
    private $mangaRecords;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="record", cascade={"persist", "remove"})
     */
    private User $user;

    public function __construct()
    {
        $this->mangaRecords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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