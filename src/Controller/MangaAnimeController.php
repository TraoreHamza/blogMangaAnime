<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Review;
use App\Entity\MangaAnime;
use App\Repository\MangaAnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/mangaAnime')]
final class MangaAnimeController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private MangaAnimeRepository $mangaAnimeRepository,
    ) {}

    // Route pour touts les mangaAnime
    #[Route('s', name: 'mangaAnimes', methods: ['GET'])]
    public function index(): Response
    {
        $mangaAnimes = $this->mangaAnimeRepository->findAll();

        $user = $this->getUser();
        $favorisIds = [];

        if ($user instanceof User) {
            // Récupère les IDs des mangas favoris de l'utilisateur
            foreach ($user->getFavoris() as $favori) {
                $favorisIds[] = $favori->getMangaAnimes()->getId();
            }
        }
        return $this->render('manga_anime/index.html.twig', [
            'mangaAnimes' => $mangaAnimes,
            'favorisIds' => $favorisIds,
        ]);
    }

    // afficher les detail d'un mangaAnime
    #[Route('/{id}', name: 'mangaAnime_view', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function view(int $id): Response
    {
        $mangaAnime = $this->mangaAnimeRepository->find($id);
        if (!$mangaAnime) {
            $this->addFlash('error', 'Manga/Anime not found.');
            return $this->redirectToRoute('mangaAnimes');
        }

        $reviews = $mangaAnime->getReviews();
        $count = count($reviews);
        $sumRatings = 0;

        foreach ($reviews as $review) {
            $sumRatings += $review->getRating();
        }

        $averageRating = $count > 0 ? round($sumRatings / $count, 1) : 0;

        return $this->render('manga_anime/view.html.twig', [
            'mangaAnime' => $mangaAnime,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
        ]);
    }

    #[Route('/manga/{id}/review/add', name: 'review_add', methods: ['POST'])]
    public function addReview(Request $request, MangaAnime $mangaAnime, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $rating = (int) $request->request->get('rating');


        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour laisser un avis.');
            return $this->redirectToRoute('mangaAnime_view', ['id' => $mangaAnime->getId()]);
        }

        $review = new Review();
        $review->setUser($user);
        $review->setRating($rating);

        $this->em->persist($review);
        $this->em->flush();

        $this->addFlash('success', 'Merci pour votre avis !');
        return $this->redirectToRoute('mangaAnime_view', ['id' => $mangaAnime->getId()]);
    }

    #[Route('/manga_anime', name: 'manga_anime_filter', methods: ['GET'])]
    public function filter(Request $request, MangaAnimeRepository $repo): Response
    {
        $allItems = $repo->findAll();

        $genres = array_unique(array_map(fn($m) => $m->getGenre(), $allItems));
        sort($genres);

        $types = array_unique(array_map(fn($m) => $m->getType(), $allItems));
        sort($types);

        $selectedGenre = $request->query->get('genre');
        $selectedType = $request->query->get('type');

        if ($selectedGenre || $selectedType) {
            $items = $repo->findByGenreAndType($selectedGenre, $selectedType);
        } else {
            $items = $allItems;
        }

        return $this->render('manga_anime/index.html.twig', [
            'mangaAnimes' => $items,
            'genres' => $genres,
            'types' => $types,
            'selectedGenre' => $selectedGenre,
            'selectedType' => $selectedType,
        ]);
    }
}
