<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecommendationController extends AbstractController
{
    #[Route('/recommendation', name: 'app_recommendation')]
    public function index(): Response
    {
        return $this->render('recommendation/index.html.twig', [
            'controller_name' => 'RecommendationController',
        ]);
    }

    #[Route('/recommendation/generate', name: 'recommendation_generate', methods: ['POST'])]
    public function generate(): Response
    { /* ... */
        return new Response('Recommendation generated successfully.');
    }

    #[Route('/recommendations/user/{userId}', name: 'recommendation_get_all_by_user', methods: ['GET'])]
    public function getAllByUser(int $userId): Response
    { /* ... */
        return new Response('Recommendations for user ID: ' . $userId);
    }

    #[Route('/recommendations/mangaanime/{mangaAnimeId}', name: 'recommendation_get_all_by_mangaanime', methods: ['GET'])]
    public function getAllByMangaAnime(int $mangaAnimeId): Response
    { /* ... */
        return new Response('Recommendations for Manga/Anime ID: ' . $mangaAnimeId);
    }
}
