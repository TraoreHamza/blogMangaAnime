<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, MangaAnime>
     */
    #[ORM\ManyToMany(targetEntity: MangaAnime::class, inversedBy: 'categories')]
    private Collection $mangaAnimes;

    public function __construct()
    {
        $this->mangaAnimes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, MangaAnime>
     */
    public function getMangaAnimes(): Collection
    {
        return $this->mangaAnimes;
    }

    public function addMangaAnime(MangaAnime $mangaAnime): static
    {
        if (!$this->mangaAnimes->contains($mangaAnime)) {
            $this->mangaAnimes->add($mangaAnime);
        }

        return $this;
    }

    public function removeMangaAnime(MangaAnime $mangaAnime): static
    {
        $this->mangaAnimes->removeElement($mangaAnime);

        return $this;
    }
}
