<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReviewController extends AbstractController
{
    #[Route('/review', name: 'app_review')]
    public function index(): Response
    {
        return $this->render('review/index.html.twig', [
            'controller_name' => 'ReviewController',
        ]);
    }

    #[Route('/review', name: 'review_create', methods: ['POST'])]
    public function create(): Response
    { /* ... */
        return new Response('Review created successfully.');
    }

    #[Route('/review/{id}', name: 'review_edit', methods: ['PUT', 'PATCH'])]
    public function edit(int $id): Response
    { /* ... */
        return new Response('Review edited successfully.');
    }

    #[Route('/review/{id}', name: 'review_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    { /* ... */
        return new Response('Review deleted successfully.');
    }

    #[Route('/reviews', name: 'review_get_all', methods: ['GET'])]
    public function getAll(): Response
    { /* ... */
        return $this->render('review/list.html.twig', [
            'reviews' => [], // Fetch and pass the list of reviews
        ]);
    }

    #[Route('/review/{id}', name: 'review_get_by_id', methods: ['GET'])]
    public function getById(int $id): Response
    { /* ... */
        return $this->render('review/detail.html.twig', [
            'review' => null, // Fetch and pass the review entity by ID
        ]);
    }
}
