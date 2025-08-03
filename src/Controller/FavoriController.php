<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\MangaAnime;
use App\Repository\MangaAnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FavoriController extends AbstractController
{
    #[Route('/favori', name: 'app_favori')]
    public function index(): Response
    {
        return $this->render('favori/index.html.twig', [
            'controller_name' => 'FavoriController',
        ]);
    }
    
    // Ajouter un manga/anime aux favoris de l'utilisateur connecté
    #[Route('/favori/add/{mangaAnimeId}', name: 'favori_add', methods: ['POST'])]
    public function add(
        int $mangaAnimeId, 
        MangaAnimeRepository $mangaAnimeRepository, 
        EntityManagerInterface $entityManager
    ): Response     
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $mangaAnime = $mangaAnimeRepository->find($mangaAnimeId);
        if (!$mangaAnime) {
            return $this->json(['success' => false, 'message' => 'Manga/Anime introuvable.'], 404);
        }

        // Vérifie si déjà dans les favoris pour éviter les doublons
        if ($user->getFavoris()->contains($mangaAnime)) {
            return $this->json(['success' => false, 'message' => 'Déjà dans les favoris.'], 400);
        }

        $user->addFavoris($mangaAnime);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['success' => true, 'message' => 'Manga/Anime ajouté aux favoris.']);
    }

    // Retirer un manga/anime des favoris de l'utilisateur connecté
    #[Route('/favori/remove/{mangaAnimeId}', name: 'favori_remove', methods: ['POST'])]
    public function remove(
        int $mangaAnimeId, 
        MangaAnimeRepository $mangaAnimeRepository, 
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $mangaAnime = $mangaAnimeRepository->find($mangaAnimeId);
        if (!$mangaAnime) {
            return $this->json(['success' => false, 'message' => 'Manga/Anime introuvable.'], 404);
        }

        if (!$user->getFavoris()->contains($mangaAnime)) {
            return $this->json(['success' => false, 'message' => 'Pas dans vos favoris.'], 400);
        }

        $user->removeFavoris($mangaAnime);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['success' => true, 'message' => 'Favori supprimé.']);
    }

    // Afficher la liste des favoris de l'utilisateur connecté
    #[Route('/favori/list', name: 'favori_list', methods: ['GET'])]
    public function list(): Response    
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $favorites = $user->getFavoris();

        return $this->render('favori/list.html.twig', [
            'favorites' => $favorites,
        ]);
    }
}
