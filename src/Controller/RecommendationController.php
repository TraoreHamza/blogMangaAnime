<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\MangaAnime;
use App\Repository\MangaAnimeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class RecommendationController extends AbstractController
{
    private MangaAnimeRepository $mangaAnimeRepository;
    private UserRepository $userRepository;

    public function __construct(MangaAnimeRepository $mangaAnimeRepository, UserRepository $userRepository)
    {
        $this->mangaAnimeRepository = $mangaAnimeRepository;
        $this->userRepository = $userRepository;
    }

    #[Route('/recommendation', name: 'app_recommendation')]
    public function index(): Response
    {
        return $this->render('recommendation/index.html.twig');
    }

    // Génération de recommandations personnalisées (POST)
    #[Route('/recommendations/generate', name: 'recommendation_generate', methods: ['POST'])]
    public function generate(Request $request): Response
    {
        // Générer des recommandations pour l'utilisateur connecté
        /** @var User $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // // Logique personnalisée (ici genre préféré ou autres critères)
        // $favGenres = $user->getFavoriteGenres() ?? []; 
        // if (empty($favGenres)) {
        //     $recommendations = $this->mangaAnimeRepository->findBy([], ['popularity' => 'DESC'], 5);
        // } else {
        //     $recommendations = $this->mangaAnimeRepository->findByGenres($favGenres, 5);
        // }

        return $this->render('recommendation/list.html.twig', [
            // 'recommendations' => $recommendations,
            'user' => $user,
        ]);
    }

    // Obtenir des recommandations pour un utilisateur spécifique
    #[Route('/recommendations/user/{userId}', name: 'recommendation_get_by_user', methods: ['GET'])]
    public function getByUser(int $userId): Response
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw $this->createNotFoundException("Utilisateur non trouvé.");
        }

        $favGenres = $user->getFavoriteGenres() ?? [];
        if (empty($favGenres)) {
            $recommendations = $this->mangaAnimeRepository->findBy([], ['popularity' => 'DESC'], 5);
        } else {
            $recommendations = $this->mangaAnimeRepository->findByGenres($favGenres, 5);
        }

        return $this->render('recommendation/list.html.twig', [
            'recommendations' => $recommendations,
            'user' => $user,
        ]);
    }

    // Obtenir des recommandations pour un manga/anime donné (par similarité de genre)
    #[Route('/recommendations/manga/{mangaId}', name: 'recommendation_get_by_manga', methods: ['GET'])]
    public function getByManga(int $mangaId): Response
    {
        $manga = $this->mangaAnimeRepository->find($mangaId);
        if (!$manga) {
            throw $this->createNotFoundException("Manga/Anime non trouvé.");
        }

        $similar = $this->mangaAnimeRepository->findSimilar($manga, 5);

        return $this->render('recommendation/list.html.twig', [
            'subject' => $manga,
            'recommendations' => $similar,
        ]);
    }
}
