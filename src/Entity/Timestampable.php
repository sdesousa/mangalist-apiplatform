<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

trait Timestampable
{
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull(message="Date de création obligatoire")
     * @Assert\DateTime(message="Dois être une date")
     * @var DateTimeInterface
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime(message="Dois être une date")
     * @var DateTimeInterface
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
