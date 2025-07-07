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

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\ManyToOne(inversedBy: 'recommendations')]
    private ?User $recommendations = null;

    #[ORM\ManyToOne(inversedBy: 'recommendations')]
    private ?MangaAnime $mangaAnimes = null;

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

    public function getRecommendations(): ?User
    {
        return $this->recommendations;
    }

    public function setRecommendations(?User $recommendations): static
    {
        $this->recommendations = $recommendations;

        return $this;
    }

    public function getMangaAnimes(): ?MangaAnime
    {
        return $this->mangaAnimes;
    }

    public function setMangaAnimes(?MangaAnime $mangaAnimes): static
    {
        $this->mangaAnimes = $mangaAnimes;

        return $this;
    }
}
