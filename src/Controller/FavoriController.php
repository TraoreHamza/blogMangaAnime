<?php

namespace App\Controller;

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

    #[Route('/favori/add', name: 'favori_add', methods: ['POST'])]
    public function add(): Response
    { /* ... */
        return new Response('Favori added successfully.');
    }

    #[Route('/favori/remove', name: 'favori_remove', methods: ['POST'])]
    public function remove(): Response
    { /* ... */
        return new Response('Favori removed successfully.');
    }

    #[Route('/favoris', name: 'favori_list', methods: ['GET'])]
    public function list(): Response
    { /* ... */
        return $this->render('favori/list.html.twig', [
            'favoris' => [], // Fetch and pass the list of favoris
        ]);
    }
}
