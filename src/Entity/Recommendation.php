<?php

namespace App\Entity;

use App\Repository\RecommendationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecommendationRepository::class)]
class Recommendation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $score = 0;

    #[ORM\ManyToOne(inversedBy: 'recommendations')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'recommendations')]
    private ?MangaAnime $mangaAnime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMangaAnime(): ?MangaAnime
    {
        return $this->mangaAnime;
    }

    public function setMangaAnime(?MangaAnime $mangaAnime): static
    {
        $this->mangaAnime = $mangaAnime;

        return $this;
    }
}
