<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait Timestampable.
 */
trait Timestampable
{
    /**
     * @ORM\Column(type="datetime")
     * @Groups({"timestamp"})
     * @Assert\NotNull(message="Date de création obligatoire")
     * @Assert\Type("\DateTimeInterface", message="Dois être une date")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"timestamp"})
     * @Assert\Type("\DateTimeInterface", message="Dois être une date")
     *
     * @var ?DateTimeInterface
     */
    private ?DateTimeInterface $updatedAt;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
