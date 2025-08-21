<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\MangaAnime;
use App\Entity\Recommendation;
use App\Repository\UserRepository;
use App\Repository\MangaAnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecommendationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class RecommendationController extends AbstractController
{
    private RecommendationRepository $recommendationRepository;
    private MangaAnimeRepository $mangaAnimeRepository;
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(MangaAnimeRepository $mangaAnimeRepository, RecommendationRepository $recommendationRepository, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->mangaAnimeRepository = $mangaAnimeRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->recommendationRepository = $recommendationRepository;
    }

    #[Route('/recommendation', name: 'app_recommendation')]
    public function index(): Response
    {
        return $this->render('recommendation/index.html.twig');
    }

    #[Route('/recommendations/generate', name: 'recommendation_generate', methods: ['POST'])]
    public function generate(Request $request): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les genres favoris de l'utilisateur
        $favGenres = $user->getFavoris() ? $user->getFavoris()->toArray() : [];

        if (empty($favGenres)) {
            // Top 5 des mangas/animes les plus populaires
            $recommendationsData = $this->mangaAnimeRepository->findBy([], ['popularity' => 'DESC'], 5);
        } else {
            // Recherche personnalisée selon genres favoris
            $recommendationsData = $this->mangaAnimeRepository->findByGenres($favGenres, 5);
        }

        // Supprimer les recommandations existantes pour cet utilisateur 
        $existingRecs = $this->recommendationRepository->findBy(['user' => $user]);
        foreach ($existingRecs as $rec) {
            $this->entityManager->remove($rec);
        }
        $this->entityManager->flush();

        // Créer et persister les nouvelles recommandations
        foreach ($recommendationsData as $mangaAnime) {
            $recommendation = new Recommendation();
            $recommendation->setUser($user);
            $recommendation->setMangaAnime($mangaAnime);

            $this->entityManager->persist($recommendation);
        }
        $this->entityManager->flush();

        // Redirection vers la liste des recommandations pour l'utilisateur
        return $this->redirectToRoute('recommendation_user', ['userId' => $user->getId()]);
    }

    // Obtenir des recommandations pour un utilisateur spécifique
    #[Route('/recommendations/user/{userId}', name: 'recommendation_user', methods: ['GET'])]
    public function getByUser(string $userId): Response
    {
        if (!ctype_digit($userId)) {
            throw $this->createNotFoundException("L'identifiant utilisateur doit être un entier.");
        }

        $userId = (int) $userId;

        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw $this->createNotFoundException("Utilisateur non trouvé.");
        }

        $favGenres = $user->getFavoris() ?? [];

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
    #[Route('/recommendations/manga/{mangaId}', name: 'recommendation_manga', methods: ['GET'])]
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
