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

    // Route pour touts les manaAnime
    #[Route('s', name: 'mangaAnime', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('manga_anime/index.html.twig', [
            'controller_name' => 'MangaAnimeController',
        ]);
    }

    #[Route('/new', name: 'mangaanime_new', methods: ['POST', 'GET'])]
    public function new(Request $request): Response
    { /* ... */
        // Nouvelle Manga/Anime creation logic
        $mangaAnime = new MangaAnime();
        
        
        return new Response('Manga/Anime created successfully.');
    }

    #[Route('/mangaanime/{id}', name: 'mangaanime_edit', methods: ['PUT', 'PATCH'])]
    public function edit(int $id): Response
    { /* ... */
        return new Response('Manga/Anime edited successfully.');
    }

    #[Route('/mangaanime/{id}', name: 'mangaanime_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    { /* ... */
        return new Response('Manga/Anime deleted successfully.');
    }

    #[Route('/mangaanimes', name: 'mangaanime_get_all', methods: ['GET'])]
    public function getAll(): Response
    { /* ... */
        return $this->render('manga_anime/list.html.twig', [
            'manga_animes' => [], // Fetch and pass the list of Manga/Anime entities
        ]);
    }

    #[Route('/mangaanime/{id}', name: 'mangaanime_get_by_id', methods: ['GET'])]
    public function getById(int $id): Response
    { /* ... */
        return $this->render('manga_anime/detail.html.twig', [
            'manga_anime' => null, // Fetch and pass the Manga/Anime entity by ID
        ]);
    }

    #[Route('/mangaanime/add-to-list', name: 'mangaanime_add_to_list', methods: ['POST'])]
    public function addToList(): Response
    { /* ... */
        return new Response('Manga/Anime added to list successfully.');
    }

    #[Route('/mangaanime/filter', name: 'mangaanime_filter', methods: ['GET'])]
    public function filter(): Response
    { /* ... */
        return $this->render('manga_anime/filter.html.twig', [
            'filters' => [], // Fetch and pass available filters
        ]);
    }
}
