<?php

namespace App\Twig\Components;

use App\Repository\ArticleRepository;
use App\Repository\MangaAnimeRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('Search', template: 'components/Search.html.twig')]
final class Search
{
    use DefaultActionTrait;

    #[LiveProp(writable: true, url: true)]
    public ?string $query = null;

    public function __construct(
        private ArticleRepository $articleRepository,
        private MangaAnimeRepository $mangaAnimeRepository
    ) {}

    public function getResults(): array
    {
        if ($this->query) {
            // Cherche dans les articles par titre
            $articles = $this->articleRepository->searchByTitle($this->query);

            // Cherche dans les mangas/animes par titre 
            $mangas = $this->mangaAnimeRepository->searchByTitle($this->query);

            // Limite à 10 résultats chacun si besoin
            if (count($articles) > 10) {
                $articles = array_slice($articles, 0, 10);
            }
            if (count($mangas) > 10) {
                $mangas = array_slice($mangas, 0, 10);
            }

            return [
                'articles' => $articles,
                'mangas' => $mangas,
            ];
        }
        
        return [
            'articles' => [],
            'mangas' => [],
        ];
    }
}
