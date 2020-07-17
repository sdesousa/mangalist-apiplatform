<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRoleRepository")
 * @UniqueEntity(
 *     fields={"role"},
 *     message="Rôle déjà présent"
 * )
 */
class AuthorRole
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Role obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Role trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private string $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MangaAuthor", mappedBy="authorRole")
     * @var Collection<int, MangaAuthor>
     */
    private Collection $mangaAuthors;

    public function __construct()
    {
        $this->mangaAuthors = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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
            $mangaAuthor->setAuthorRole($this);
        }

        return $this;
    }

    public function removeMangaAuthor(MangaAuthor $mangaAuthor): self
    {
        if ($this->mangaAuthors->contains($mangaAuthor)) {
            $this->mangaAuthors->removeElement($mangaAuthor);
            // set the owning side to null (unless already changed)
            if ($mangaAuthor->getAuthorRole() === $this) {
                $mangaAuthor->setAuthorRole(null);
            }
        }

        return $this;
    }
}
