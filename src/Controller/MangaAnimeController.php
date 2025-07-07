<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MangaAnimeController extends AbstractController
{
    #[Route('/manga/anime', name: 'app_manga_anime')]
    public function index(): Response
    {
        return $this->render('manga_anime/index.html.twig', [
            'controller_name' => 'MangaAnimeController',
        ]);
    }
}
