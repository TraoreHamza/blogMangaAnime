<?php

namespace App\Controller;

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
    ){}

    // Route pour touts les mangaAnime
    #[Route('s', name: 'mangaAnimes', methods: ['GET'])]
    public function index(): Response
    {
        $mangaAnimes = $this->mangaAnimeRepository->findAll();
        return $this->render('manga_anime/index.html.twig', [
            'mangaAnimes' => $mangaAnimes,
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
        return $this->render('manga_anime/view.html.twig', [
            'mangaAnime' => $mangaAnime,
        ]);
    }
    
    // filtrer les mangaAnimes
    #[Route('/filter', name: 'mangaAnime_filter', methods: ['GET'])]
    public function filter(Request $request): Response
    {
        $filters = $request->query->all();
        $mangaAnimes = $this->mangaAnimeRepository->findByFilters($filters);
        return $this->render('manga_anime/filter.html.twig', [
            'mangaAnimes' => $mangaAnimes,
            'filters' => $filters,
        ]);
    }
}
